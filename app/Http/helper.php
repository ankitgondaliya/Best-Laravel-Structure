<?php
    function FileUploadHelper($file,$folder) {
  		if ($file) {
            $fileName = rand(1000000,9999999).time().uniqid().'.'.$file->extension();
            if (!is_dir(public_path($folder))) {
              mkdir(public_path($folder),0755,true);
            }
	        $file->move(public_path($folder), $fileName);
	        return 'public/'.$folder.'/'.$fileName;
	    }
    }

    function destroyFileHelper($image_path)
    {
    	if(file_exists($image_path)){
	        File::delete($image_path);
	    }
    }

    function success($message, $data = null) {
        $dataArray = [
            'status' => true,
            'status_code' => 200,
            'message' => $message,
        ];

        if (isset($data) && !is_null($data)) {
            $dataArray['data'] = $data;
        }

        return response()->json($dataArray, 200);
    }

    function error($message, $originalMessage = null) {
        $arr = [
            'status' => false,
            'status_code' => 400,
            'message' => $message,
        ];
        if($originalMessage != null ){
            $arr['original_message']  = $originalMessage;
        }
        return response()->json(
            $arr,
            200
        );
    }
    function notfound($message = null) {
        $arr = [
            'status' => false,
            'status_code' => 404,
            'message' => $message == null ? "Page Not found" : $message,
        ];
        return response()->json(
            $arr,
            404
        );
    }

    function validatorError($validate) {
        return response()->json(
            [
                'status' => false,
                'status_code' => 422,
                'message' => $validate->messages()->first(),
                'errors' => $validate->errors(),
            ],
            200
        );
    }

    function loginAndSignupSuccess($message, $tokenBody, $data = null) {
        $response = array_merge([
            'status' => true,
            'status_code' => 200,
            'message' => $message,
        ],$tokenBody);

        if (isset($data)) {
            $response = array_merge($response, [
                'data' =>$data,
            ]);
        }
        return response()->json($response);
    }
?>
