<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use DB;

class ScanController extends Controller
{
    public function index()
    {
        return view("production-qr");
    }

    // public function scanItem(Request $request)
    // {
    //     if ($request->code) {
    //         $data = null;

    //         if (preg_match('/STK/i', $request->code)) {
    //             // Stocker
    //             $data = DB::table("stocker_input")->leftJoin("master_sb_ws", "master_sb_ws.id_so_det", "=", "stocker_input.so_det_id")->leftJoin("part_detail", "part_detail.id", "=", "stocker_input.part_detail_id")->leftJoin("master_part", "master_part.id", "=", "part_detail.master_part_id")->where("id_qr_stocker", $request->code)->first();
    //         } else {
    //             // Numbering
    //             $codes = explode("_", $request->code);

    //             if (count($codes) > 2) {
    //                 $code = substr($codes[0], 0, 4) . "_" . $codes[1] . "_" . $codes[2];
    //                 $data = DB::table("year_sequence")->leftJoin("master_sb_ws", "master_sb_ws.id_so_det", "=", "year_sequence.so_det_id")->where("id_year_sequence", $code)->first();
    //             } else {
    //                 $code = $request->code;
    //                 $data = DB::table("month_count")->leftJoin("master_sb_ws", "master_sb_ws.id_so_det", "=", "month_count.so_det_id")->where("id_month_year", $code)->first();
    //             }
    //         }

    //         return $data;
    //     }

    //     return null;
    // }


    public function getdataqr(Request $request)
    {
        $codes = explode("_", $request->txtqr);

        if (count($codes) > 2) {
            $qr = substr($codes[0], 0, 4) . "_" . $codes[1] . "_" . $codes[2];
        } else {
            $qr = $request->txtqr;
        }

        $data_master_trans = DB::select("
            select
            m.buyer,
            m.ws,
            m.styleno,
            m.season,
            m.color,
            m.size,
            group_concat(distinct(lot)) lot,
            concat(lebar_marker , ' ', unit_lebar_marker) width,
            count(fd.roll) tot_roll,
            mi.kode,
            u.name,
            f.no_form,
            m.dest
            from (
            select id_year_sequence, form_cut_id, so_det_id from year_sequence a
            where id_year_sequence = '$qr'
            ) a
            inner join master_sb_ws m on a.so_det_id = m.id_so_det
            left join form_cut_input f on a.form_cut_id = f.id
            left join marker_input mi on f.id_marker = mi.kode
            left join form_cut_input_detail fd on f.no_form = fd.no_form_cut_input
            left join users u on f.no_meja = u.id
            group by fd.id_item");

        return json_encode($data_master_trans ? $data_master_trans[0] : '-');
    }

    public function getdataqr_sb(Request $request)
    {
        $codes = explode("_", $request->txtqr);

        if (count($codes) > 2) {
            $qr = substr($codes[0], 0, 4) . "_" . $codes[1] . "_" . $codes[2];
        } else {
            $qr = $request->txtqr;
        }

        $data_sb = DB::connection('mysql_sb')->select("
            select
            a.sewing_line,
            a.defect_status,
            a.defect_type,
            a.allocation as defect_allocation,
            a.external,
            a.external_status,
            a.external_in,
            a.external_out,
            b.packing_line,
            b.packing_defect_status,
            b.packing_defect_type,
            b.packing_allocation as packing_defect_allocation,
            b.packing_external,
            b.packing_external_status,
            b.packing_external_in,
            b.packing_external_out,
            master_plan_id,
            tgl_plan,
            DATE_FORMAT(tgl_plan, '%d-%m-%Y') AS tgl_plan_fix
            from (
                select o.kode_numbering,u.name sewing_line, '-' defect_status, '-' defect_type, '-' allocation, master_plan_id, '-' as external, '-' as external_status, '-' as external_in, '-' as external_out
                from output_rfts o
                left join user_sb_wip u on o.created_by = u.id
                where o.kode_numbering = '".$qr."'
                union
                select o.kode_numbering,u.name sewing_line, o.defect_status, dt.defect_type, dt.allocation, master_plan_id, dio.type as external, dio.status as external_status, dio.created_at as external_in, dio.reworked_at as external_out
                from output_defects o
                left join user_sb_wip u on o.created_by = u.id
                left join output_defect_types dt on dt.id = o.defect_type_id
                left join output_defect_in_out dio on dio.defect_id = o.id and dio.output_type = 'qc'
                where o.kode_numbering = '".$qr."'
            ) a
            left join (
                select kode_numbering,u.name packing_line, '-' packing_defect_status, '-' packing_defect_type, '-' packing_allocation, '-' as packing_external, '-' as packing_external_status, '-' as packing_external_in, '-' as packing_external_out
                from output_rfts_packing o
                left join user_sb_wip u on o.created_by = u.id
                where kode_numbering = '".$qr."'
                union
                select o.kode_numbering,u.name packing_line, o.defect_status packing_defect_status, dt.defect_type packing_defect_type, dt.allocation packing_allocation, dio.type as packing_external, dio.status as packing_external_status, dio.created_at as packing_external_in, dio.reworked_at as packing_external_out
                from output_defects_packing o
                left join user_sb_wip u on o.created_by = u.id
                left join output_defect_types dt on dt.id = o.defect_type_id
                left join output_defect_in_out dio on dio.defect_id = o.id and dio.output_type = 'packing'
                where o.kode_numbering = '".$qr."'
            ) b on a.kode_numbering = b.kode_numbering
            inner join master_plan mp on a.master_plan_id = mp.id
        ");
        return json_encode($data_sb ? $data_sb[0] : '-');
    }

    public function getdataqr_gambar(Request $request)
    {
        $id = $request->id;
        $data_gambar = DB::connection('mysql_sb')->select("
            select gambar from master_plan where id = '$id'
            ");
        return json_encode($data_gambar[0]);
    }
}
