<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Exceptions;
use AlibabaCloud\Dm\Dm;
use AlibabaCloud\Client\AlibabaCloud;
use AlibabaCloud\Client\Exception\ClientException;
use AlibabaCloud\Client\Exception\ServerException;

class DMController extends Controller
{
    //
    public function __construct()
    {
        $this->receiverEmail = "mudgolem333@gmail.com";
        $this->data = "hi hi hi ";
        $this->subject = "Test Subjest ";
        $this->receiverName = "Board SO H";
    }


    public function handle(){
        try{
            # 1.1 : Establish a Alibaba DM mail client before send DM email [ Documentation : https://github.com/aliyun/openapi-sdk-php-client/blob/master/README.md ]
            AlibabaCloud::accessKeyClient(env("ALIYUN_MAIL_KEY"), env("ALIYUN_MAIL_SEC"))
                ->regionId(env("ALIYUN_REGION")) 
                ->timeout(1) 
                ->connectTimeout(0.1) 
                ->debug(true) 
                ->asDefaultClient();

            // # 1.2 : Create a DM mail method [ Documentation : https://github.com/alibabacloud-sdk-php/dm ]
            $return=Dm::v20151123()
                ->singleSendMail()
                ->setAccountName(env("ALIYUN_SYS_EMAIL"))
                ->setReplyToAddress("false")
                ->setAddressType(1)
                ->setToAddress("mudgolem333@gmail.com")
                ->setFromAlias(env("ALIYUN_SYS_EMAIL"))
                ->setSubject("thst subject")
                ->setHtmlBody("hi hi hi ")
                ->setClickTrace("0")
                ->request();
            dd($return);
        }
        catch (ClientException $exception) {  
            dd( $exception->getMessage());
        } catch (ServerException $exception) {
            dd ($exception->getMessage());
        }
        catch (\Exception $e){
            dd($e);
        }
    }
}
