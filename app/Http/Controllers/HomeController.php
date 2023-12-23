<?php

namespace App\Http\Controllers;

use App\Models\Fund;
use App\Models\FundCategory;
use Barryvdh\DomPDF\PDF;
use Dompdf\Dompdf;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Response;
use Maatwebsite\Excel\Excel as ExcelExcel;
use Maatwebsite\Excel\Facades\Excel;
use PhpOffice\PhpSpreadsheet\Spreadsheet;
use PhpOffice\PhpSpreadsheet\Writer\Xlsx;

class HomeController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('auth');
    }

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Contracts\Support\Renderable
     */
    public function index(Request $request)
    {
        
        //DB::enableQueryLog();
        $query = Fund::query();
        $queryCat = FundCategory::query();

        if(request()->has('cat')){
            $fund_category_id = request()->input('cat');
            $query->where('fund_category_id', $fund_category_id);
            $funds = $query->paginate(10);
            $fundCategories = $queryCat->where('id', request()->input('cat'));
            $fundCategories = FundCategory::all();

        } else if (request()->has('search')) {
                $searchTerm = request()->input('search');
                $query->where('name', 'like', "$searchTerm")
                    ->orWhere('ISIN', 'like', "%$searchTerm%")
                    ->orWhere('WKN', 'like', "%$searchTerm%");
                $funds = $query->paginate(10);
                $fundCategories = FundCategory::all();
                
                //dd($searchTerm);


        
        } else {
            $funds = Fund::all();
            $funds = Fund::paginate(10);
            $fundCategories = FundCategory::all();
        }
        //dd($funds); 
        return view('home', compact('funds', 'fundCategories'));
    }


    public function favorites() {

        $favorites = collect(session()->get('favorites', []))->unique('id')->values();
        //dd($favorites);

        return view('favorites', compact('favorites'));

    }
    
    public function addToFavorites(Request $request, $id)
    {
        $fund = Fund::find($id);

        if (!$request->session()->has('favorites')) {
            $request->session()->put('favorites', []);
        }
        $favorites = $request->session()->get('favorites');
        $favorites[] = $fund;
        $request->session()->put('favorites', $favorites);

        return redirect()->back();
    }


    public function remove(Request $request, $id) {
        $fund = Fund::find($id);

        $favorites = $request->session()->get('favorites', []);
        
        $updatedFavorites = array_filter($favorites, function ($favorites) use ($id){
            return $favorites['id'] != $id;
        });
        session()->put('favorites', $updatedFavorites);

        return redirect()->back();

    }


    public function downloadPdf($id) {
        
            $fund = Fund::find($id);
    
            $pdf = new Dompdf();
            $pdf->loadHtml(view('fund_pdf', compact('fund')));
            $pdf->setPaper('A4', 'landscape');
            $pdf->render();

            return $pdf->stream('fund_data_'.$id.'_.pdf');
    }


    public function downloadXlsx($id) {
        $fund = Fund::find($id);
        //dd($fund);


        $spreadsheet = new Spreadsheet();;
        $sheet = $spreadsheet->getActiveSheet();

        // Postavite podatke u ćelije
        $sheet->setCellValue('A1', 'ID');
        $sheet->setCellValue('B1', 'Name');
        $sheet->setCellValue('C1', 'FundCategoryID');
        $sheet->setCellValue('D1', 'FundSubCategoryID');
        $sheet->setCellValue('E1', 'ISIN');
        $sheet->setCellValue('F1', 'WKN');
        $sheet->setCellValue('G1', 'Created At');
        $sheet->setCellValue('H1', 'Updated At');

        $sheet->setCellValue('A2', $fund->id);
        $sheet->setCellValue('B2', $fund->name);
        $sheet->setCellValue('C2', $fund->fundCategory->name);
        $sheet->setCellValue('D2', $fund->fundSubCategory->name);
        $sheet->setCellValue('E2', $fund->ISIN);
        $sheet->setCellValue('F2', $fund->WKN);
        $sheet->setCellValue('G2', $fund->created_at);
        $sheet->setCellValue('H2', $fund->updated_at);

        // Kreirajte objekat za cuvanje u .xlsx fajl
        $writer = new Xlsx($spreadsheet);

        // Kreirajte privremeni fajl za čuvanje
        $tempFileName = tempnam(sys_get_temp_dir(), 'fund_data_');

        // sacuvajte dokument u privremeni fajl
        $writer->save($tempFileName);

        // Postavite odgovarajuci zaglavlje za preuzimanje
        header('Content-Type: application/vnd.openxmlformats-officedocument.spreadsheetml.sheet');
        header('Content-Disposition: attachment;filename="fund_data_'.$id.'.xlsx"');
        header('Cache-Control: max-age=0');

        // Citajte fajl i šaljite ga korisniku
        readfile($tempFileName);

        // Obrisite privremeni fajl
        unlink($tempFileName);

        // Prekini izvršavanje kako biste sprečili izlazak dodatnog HTML-a ili drugog sadržaja
        exit();

        
    }


    public function downloadXml($id) {
        
        $fund = Fund::find($id);

        $data = [
            ['ID', 'Name', 'FundCategoryID', 'FundSubCategoryID', 'ISIN', 'WKN'],
            [$fund->id, $fund->name, $fund->fundCategory->name, $fund->fundSubCategory->name, $fund->ISIN, $fund->WKN],
        ];

        $xmlContent = $this->arrayToXml($data);

        $headers = [
            'Content-Type' => 'application/xml',
            'Content-Disposition' => 'attachment; filename="fund_data_'.$id.'.xml"',
        ];

        return Response::make($xmlContent, 200, $headers);

    }

    private function arrayToXml($data, $rootNodeName = 'fund', $xml = null){
        if ($xml === null) {
            $xml = new \SimpleXMLElement('<' . $rootNodeName . '/>');
        }
    
        foreach ($data as $row) {
            $itemNode = $xml->addChild('item');
            foreach ($row as $key => $value) {
                // Konvertuj specijalne karaktere u XML entitete
                $value = htmlspecialchars($value, ENT_XML1);
                // Koristi ključ kao naziv elementa umesto indeksa
                $itemNode->addChild($key, $value);
            }
        }
        //dd($xml->asXML());
    
        return $xml->asXML();
    }
    
}
