<?php
// Presentador para la versión v0 del dashboard
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
