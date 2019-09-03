<?php
namespace App\Models\Traits;

trait ApiValidationError
{
   public function RequestHasError(\Illuminate\Support\Facades\Request $request){

       if ($request->has('error'))
       {
           return  response()->json(['error'=>$request->all()['error']],419);
       }
   }
}
