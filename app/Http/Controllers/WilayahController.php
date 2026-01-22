<?php

namespace App\Http\Controllers;

use App\Models\Province;
use App\Models\Regency;
use App\Models\District;
use App\Models\Village;
use App\Models\Island;
use Illuminate\Http\Request;

class WilayahController extends Controller
{
    public function index()
    {
        $provinces = Province::withCount('regencies')->get();
        return view('wilayah.index', compact('provinces'));
    }

    public function province($code)
    {
        $province = Province::with('regencies')->where('code', $code)->firstOrFail();
        return view('wilayah.province', compact('province'));
    }

    public function regency($code)
    {
        $regency = Regency::with(['province', 'districts', 'islands'])
            ->where('code', $code)
            ->firstOrFail();
        return view('wilayah.regency', compact('regency'));
    }

    public function district($code)
    {
        $district = District::with(['regency.province', 'villages'])
            ->where('code', $code)
            ->firstOrFail();
        return view('wilayah.district', compact('district'));
    }

    public function village($code)
    {
        $village = Village::with('district.regency.province')
            ->where('code', $code)
            ->firstOrFail();
        return view('wilayah.village', compact('village'));
    }

    public function islands()
    {
        $islands = Island::with('regency')->get();
        return view('wilayah.islands', compact('islands'));
    }
}
