<?php

namespace App\Helpers;

use DB;
use Auth;
use Datetime;
use Request;
use URL;
use Str;

class Custom
{
	//Auto Increment
		public static function autoIncrementKey($table='',$id='')
		{
			$autoincrement 		= DB::table($table)->max($id);
			$id_auto_increment 	= $autoincrement + 1;
			return $id_auto_increment;
		}
	//Auto Increment

	//Library
		public static function randomNumberSequence($requiredLength = 7, $highestDigit = 8)
		{
		    $sequence = '';
		    for ($i = 0; $i < $requiredLength; ++$i) {
		        $sequence .= mt_rand(0, $highestDigit);
		    }
		    return $sequence;
		}
	//Library

	//Notifikasi
		public static function pesanErorForm($form_input='')
		{
			if($form_input != '')
				echo '<div class="errorform">'.$form_input.'</div>';
		}

		public static function pesanErorFormFile($form_input='')
		{
			if($form_input != '')
				echo '<div class="errorformfile">'.$form_input.'</div>';
		}

		public static function pesanSuksesForm($form_input='')
		{
			if($form_input != '')
				echo '<div class="alert alert-success" role="alert">'.$form_input.'</div>';
		}

		public static function pesanFlashErorForm($form_input = '')
		{
			if ($form_input != '')
				echo '<div class="alert alert-danger" role="alert">' . $form_input . '</div>';
		}

		public static function validForm($alert="")
		{
			if($alert != '')
				echo 'is-invalid';
		}
	//Notifikasi

}