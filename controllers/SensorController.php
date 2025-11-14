<?php

class SensorController {

    public static function store($model) {
        try {
            $lat = $_POST['latitude'] ?? null;
            $lng = $_POST['longitude'] ?? null;
            $volt = $_POST['voltage'] ?? null;

            if (!$lat || !$lng || !$volt) {
                return Response::json([
                    "status" => "error",
                    "message" => "Data tidak lengkap"
                ], 400);
            }

            if ($model->insert($lat, $lng, $volt)) {
                return Response::json([
                    "status" => "success",
                    "message" => "Data tersimpan"
                ]);
            }

            return Response::json([
                "status" => "error",
                "message" => "Gagal insert"
            ], 500);

        } catch (Exception $e) {
            return Response::json([
                "status" => "error",
                "message" => $e->getMessage()
            ], 500);
        }
    }

    public static function index($model) {
        try {
            $data = $model->getAll();
            return Response::json(["status" => "success", "data" => $data]);
        } catch (Exception $e) {
            return Response::json(["status" => "error", "message" => $e->getMessage()], 500);
        }
    }

    // ===========================================
    // SHOW DENGAN ID DARI ROUTE /sensor/{id}
    // ===========================================
    public static function show($model, $id) {
        try {
            $data = $model->getById($id);

            if (!$data) {
                return Response::json([
                    "status" => "error",
                    "message" => "Data tidak ditemukan"
                ], 404);
            }

            return Response::json([
                "status" => "success",
                "data" => $data
            ]);

        } catch (Exception $e) {
            return Response::json(["status" => "error", "message" => $e->getMessage()]);
        }
    }

    // ===========================================
    // DELETE DENGAN ID DARI ROUTE /sensor/{id}
    // ===========================================
    public static function destroy($model, $id) {
        try {
            if ($model->delete($id)) {
                return Response::json([
                    "status" => "success",
                    "message" => "Data terhapus"
                ]);
            }

            return Response::json([
                "status" => "error",
                "message" => "Gagal menghapus"
            ], 500);

        } catch (Exception $e) {
            return Response::json(["status" => "error", "message" => $e->getMessage()], 500);
        }
    }
}
