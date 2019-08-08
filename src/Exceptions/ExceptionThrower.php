<?php

namespace SmartOver\ApiResponse\Exceptions;

use SmartOver\ApiResponse\ResponseCode;

/**
 * Class ThrowException
 *
 * @package SmartOver\ApiResponse\Exceptions
 */
class ExceptionThrower {

	/**
	 * @param $message
	 *
	 * @throws GenericException
	 */
	public static function genericWithMessage( $message ) {
		throw new GenericException( 400, ResponseCode::ERR001, $message, [] );
	}

}