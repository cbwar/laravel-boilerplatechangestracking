<?php

namespace Cbwar\Laravel\BoilerplateChangesTracking\Controllers;

use App\Http\Controllers\Controller;
use Cbwar\Laravel\ModelChanges\Models\Change;
use Yajra\Datatables\Facades\Datatables;

/**
 * Class TracksController
 *
 * Manages Model Tracks
 *
 * @package Sebastienheyd\Boilerplate\Controllers\Tracks
 */
class TracksController extends Controller
{

    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('ability:admin,changestracking_view');
    }

    /**
     * Display a listing of tracks.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return view('boilerplate_tracks::admin.list');
    }

    /**
     * To display dynamic table by datatable
     *
     * @return mixed
     */
    public function index_xhr_dt()
    {
        return Datatables::of(Change::select('*')->with('user'))
            ->rawColumns(['description', 'type'])
            ->editColumn('created_at', function ($item) {
                // TODO: date i18n
                return $item->created_at->format('Y-m-d H:i:s');
            })
            ->editColumn('user_id', function ($item) {
                if (empty($item->user_id)) {
                    return '-';
                }
                return ucwords($item->user->first_name . " " . $item->user->last_name);
            })
            ->editColumn('type', function ($item) {

                $tab = explode('\\', $item->ref_model);
                $class = end($tab);

                switch ($item->type) {
                    case 'add':
                        $icon = '<i class="fa fa-plus" style="color: green"/></i>';
                        break;
                    case 'edit':
                        $icon = '<i class="fa fa-pencil" style="color: orange"/></i>';
                        break;
                    case 'delete':
                        $icon = '<i class="fa fa-trash" style="color: red"></i>';
                        break;
                    default:
                        $icon = '';
                }

                return $icon . ' <span>' . $class . ' #' . $item->ref_id . '</span>';
            })
            ->make(true);
    }
}