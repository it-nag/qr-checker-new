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
            m.dest,
            ll.nama_line line_loading,
            ll.tanggal_loading
            from (
            select id_year_sequence, form_cut_id, so_det_id, id_qr_stocker, number from year_sequence a
            where id_year_sequence = '$qr'
            ) a
            inner join master_sb_ws m on a.so_det_id = m.id_so_det
            left join form_cut_input f on a.form_cut_id = f.id
            left join marker_input mi on f.id_marker = mi.kode
            left join form_cut_input_detail fd on f.no_form = fd.no_form_cut_input
            left join stocker_input stk on stk.form_cut_id = f.id AND stk.so_det_id = a.so_det_id AND CAST(a.number AS UNSIGNED) >= CAST(stk.range_awal AS UNSIGNED) AND CAST(a.number AS UNSIGNED) <= CAST(stk.range_akhir AS UNSIGNED)
            left join loading_line ll on ll.stocker_id = stk.id
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
            b.packing_line,
            master_plan_id,
            tgl_plan,
            DATE_FORMAT(tgl_plan, '%d-%m-%Y') AS tgl_plan_fix,
            sewing_in,
            packing_in
            from (
                    select o.kode_numbering,u.name sewing_line, master_plan_id, o.created_at sewing_in
                    from output_rfts o
                    left join user_sb_wip u on o.created_by = u.id
                    where o.kode_numbering = '".$qr."'
            ) a
            left join (
                    select kode_numbering,u.FullName packing_line, o.created_at packing_in
                    from output_rfts_packing o
                    left join userpassword u on o.created_by = u.username
                    where kode_numbering = '".$qr."'
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

    public function getdataqr_defect(Request $request)
    {
        $codes = explode("_", $request->txtqr);

        if (count($codes) > 2) {
            $qr = substr($codes[0], 0, 4) . "_" . $codes[1] . "_" . $codes[2];
        } else {
            $qr = $request->txtqr;
        }

        $data_sb = DB::connection('mysql_sb')->select("
            SELECT
                merged.kode_numbering,
                merged.sewing_line,
                merged.defect_status,
                merged.defect_in,
                merged.defect_out,
                merged.defect_type,
                merged.defect_allocation,
                merged.external_status,
                merged.external_type,
                merged.external,
                merged.external_in,
                merged.external_out,

                merged.packing_line,
                merged.packing_defect_status,
                merged.packing_defect_in,
                merged.packing_defect_out,
                merged.packing_defect_type,
                merged.packing_defect_allocation,
                merged.packing_external_status,
                merged.packing_external_type,
                merged.packing_external,
                merged.packing_external_in,
                merged.packing_external_out,

                mp.id AS master_plan_id,
                mp.tgl_plan,
                DATE_FORMAT(mp.tgl_plan, '%d-%m-%Y') AS tgl_plan_fix

            FROM (
                -- 🔹 Sewing data (packing columns = NULL)
                SELECT
                    o.kode_numbering,
                    us.username AS sewing_line,
                    o.defect_status,
                    o.created_at AS defect_in,
                    CASE WHEN o.defect_status = 'reworked' THEN o.updated_at ELSE '-' END AS defect_out,
                    dt.defect_type,
                    dt.allocation AS defect_allocation,
                    dio.STATUS AS external_status,
                    dio.type AS external_type,
                    dio.output_type AS external,
                    dio.created_at AS external_in,
                    dio.reworked_at AS external_out,

                    NULL AS packing_line,
                    NULL AS packing_defect_status,
                    NULL AS packing_defect_in,
                    '-' AS packing_defect_out,
                    NULL AS packing_defect_type,
                    NULL AS packing_defect_allocation,
                    NULL AS packing_external_status,
                    NULL AS packing_external_type,
                    NULL AS packing_external,
                    NULL AS packing_external_in,
                    NULL AS packing_external_out,

                    o.master_plan_id
                FROM output_defects o
                LEFT JOIN output_defect_types dt ON dt.id = o.defect_type_id
                LEFT JOIN output_defect_in_out dio ON dio.defect_id = o.id AND dio.output_type = 'qc'
                LEFT JOIN user_sb_wip u ON o.created_by = u.id
                LEFT JOIN userpassword us ON us.line_id = u.line_id
                WHERE o.kode_numbering = '".$qr."'

                UNION

                -- 🔹 Packing data (sewing columns = NULL)
                SELECT
                    NULL as kode_numbering,
                    NULL AS sewing_line,
                    NULL AS defect_status,
                    NULL AS defect_in,
                    '-' AS defect_out,
                    NULL AS defect_type,
                    NULL AS defect_allocation,
                    NULL AS external_status,
                    NULL AS external_type,
                    NULL AS external,
                    NULL AS external_in,
                    NULL AS external_out,

                    up.username AS packing_line,
                    op.defect_status AS packing_defect_status,
                    op.created_at AS packing_defect_in,
                    CASE WHEN op.defect_status = 'reworked' THEN op.updated_at ELSE '-' END AS packing_defect_out,
                    dtt.defect_type AS packing_defect_type,
                    dtt.allocation AS packing_defect_allocation,
                    diop.STATUS AS packing_external_status,
                    diop.type AS packing_external_type,
                    diop.output_type AS packing_external,
                    diop.created_at AS packing_external_in,
                    diop.reworked_at AS packing_external_out,

                    op.master_plan_id
                FROM output_defects_packing op
                LEFT JOIN output_defect_types dtt ON dtt.id = op.defect_type_id
                LEFT JOIN output_defect_in_out diop ON diop.defect_id = op.id AND diop.output_type = 'packing'
                LEFT JOIN userpassword up ON op.created_by = up.username
                WHERE op.kode_numbering = '".$qr."'
            ) AS merged

            LEFT JOIN master_plan mp ON mp.id = merged.master_plan_id
        ");

        return json_encode($data_sb ? $data_sb[0] : '-');
    }
}
