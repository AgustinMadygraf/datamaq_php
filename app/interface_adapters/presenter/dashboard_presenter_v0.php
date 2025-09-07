<?php
/*
Path: app/interface_adapters/presenter/dashboard_presenter_v0.php
*/

class DashboardPresenterV0 {
	public function present($data, $status = 'success', $message = null) {
		$response = [
			'status' => $status,
			'data' => $data
		];
		if ($message !== null) {
			$response['message'] = $message;
		}
		return json_encode($response, JSON_UNESCAPED_UNICODE | JSON_UNESCAPED_SLASHES);
	}

	public function presentError($message, $code = 500) {
		http_response_code($code);
		return $this->present(null, 'error', $message);
	}
}
