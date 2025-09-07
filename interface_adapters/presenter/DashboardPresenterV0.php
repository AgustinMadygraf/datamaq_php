<?php
// Presentador para la versión v0 del dashboard
class DashboardPresenterV0 {
	public function present($dashboard) {
		$response = [
			'vel_ult'   => $dashboard->velUlt ?? null,
			'unixtime'  => $dashboard->unixtime ?? null,
			'rawdata'   => $dashboard->rawdata ?? [],
			// Puedes agregar aquí más campos según lo que requiera la API v0
		];
		return json_encode($response, JSON_UNESCAPED_UNICODE | JSON_UNESCAPED_SLASHES);
	}
}
