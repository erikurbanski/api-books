<?php

namespace App\Http\Controllers;

use App\Models\Views\ViewCatalog;

use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Barryvdh\DomPDF\Facade\Pdf as PDF;

class ReportController extends Controller
{
    /**
     * Report catalogue.
     * @param Request $request
     * @return Response
     */
    public function index(Request $request): Response
    {
        $catalog = ViewCatalog::query()
            ->select("*")
            ->get()
            ->toArray();

        $newCatalog = [];
        if (count($catalog) > 0) {
            foreach ($catalog as $key => $value) {
                $newCatalog[$value['name']][] = $value;
            }
        }

        $today = date('d/m/Y');
        $pdf = PDF::loadView('catalog', [
            'date' => $today,
            'catalog' => $newCatalog,
        ]);

        return $pdf->download('Catalog.pdf');
    }
}
