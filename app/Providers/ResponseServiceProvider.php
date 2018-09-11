<?php

namespace App\Providers;

use Illuminate\Support\Facades\Response;
use Illuminate\Support\ServiceProvider;
use Illuminate\Pagination\LengthAwarePaginator;

class ResponseServiceProvider extends ServiceProvider {

	public function boot() {

		// return a successful api response in json format
		Response::macro( 'success', function ($data = null, $status = 200, $metadata = []) {

			$response = [
				'timestamp' => microtime( true ),
				'success'   => true
			];

			if ( $metadata ) {
				$response['metadata'] = $metadata;
			}

			if ( $data ) {
				$response['data'] = $data;
			}

			return Response::json( $response, $status );
		} );

		// return a error api response in json format
		Response::macro( 'error', function ($message, $code = 0, $http = 500, $data = null) {

            $response = [
                'timestamp' => microtime( true ),
                'success'   => false,
                'code'      => $code,
                'message'   => $message,
            ];

            if ( $data ) {
                $response['data'] = $data;
            }

			return Response::json( $response, $http );
		} );
	}
}
