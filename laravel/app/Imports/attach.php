// $tdr_documents = $row[13]?$row[13]:0;
                // $tdr_documents_size = null;
                // $tdr_documents_date = null;
                // $filenames = [];
                // if (str_contains($tdr_documents, 'url')) {
                //     $jsonString = str_replace("'", '"', $tdr_documents);
                //     $attachments = json_decode($jsonString);
                //     if (json_last_error() !== JSON_ERROR_NONE) {
                //         Log::error('JSON Decode Error: ' . json_last_error_msg());
                //         return; 
                //     }
                //     $client = new Client();

                //     foreach ($attachments as $key => $attachment) {
                //         $att = json_encode($attachment);
                //         try {
                //             $response = $client->get($attachment->url, [
                //                 'headers' => ['Range' => 'bytes=0-1']
                //             ]);
                //             $contentRange = $response->getHeader('Content-Range');

                //             if (!empty($contentRange)) {
                //                 $file_size = (int) explode('/', $contentRange[0])[1];
                //                 if($tdr_documents_size){
                //                     $tdr_documents_size = $tdr_documents_size.'@'.$file_size;
                //                 }else{
                //                     $tdr_documents_size = $file_size;
                //                 }

                //                 if($tdr_documents_date){
                //                     $tdr_documents_date = $tdr_documents_date.'@'.$created_date;
                //                 }else{
                //                     $tdr_documents_date = $created_date;
                //                 }

                //             } else {
                //                 Log::warning('Could not determine file size for ' . $attachment->name);
                //             }
                //         } catch (\Exception $e) {
                //             Log::error('Error fetching file size for ' . $attachment->name . ': ' . $e->getMessage());
                //         }
                //     }
                // }elseif (str_contains($tdr_documents, '@')) {
                //     $filenames = explode('@', $tdr_documents);
                // } elseif (str_contains($tdr_documents, ',')) {
                //     $filenames = explode(',', $tdr_documents);
                // } else {
                //     $filenames = [$tdr_documents];
                // }

                // foreach ($filenames as $fileName) {
                //     $filepathS3 = "State/$fileName";
                //     $filepathS3Attachments = "State/attachments/$created_date/$tender_no/$fileName";
                //     $file_size = null;
                //     if (Storage::disk('s3')->exists($filepathS3)) {
                //         $file_size = Storage::disk('s3')->size($filepathS3);
                //     } elseif (Storage::disk('s3')->exists($filepathS3Attachments)) {
                //         $file_size = Storage::disk('s3')->size($filepathS3Attachments);
                //     }
                //     if($file_size){
                //         if($tdr_documents_size){
                //             $tdr_documents_size = $tdr_documents_size.'@'.$file_size;
                //         }else{
                //             $tdr_documents_size = $file_size;
                //         }

                //         if($tdr_documents_date){
                //             $tdr_documents_date = $tdr_documents_date.'@'.$created_date;
                //         }else{
                //             $tdr_documents_date = $created_date;
                //         }
                //     }
                // }