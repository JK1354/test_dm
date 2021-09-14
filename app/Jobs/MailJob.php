<?php

namespace App\Jobs;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;

// use App\Http\Controllers\DMController;
use App\Exceptions;
use AlibabaCloud\Dm\Dm;
use AlibabaCloud\Client\AlibabaCloud;
use AlibabaCloud\Client\Exception\ClientException;
use AlibabaCloud\Client\Exception\ServerException;


class MailJob implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    /**
     * Create a new job instance.
     *
     * @return void
     */
    public function __construct()
    {
        //
        $this->receiverEmail = "mudgolem333@gmail.com";
        $this->data = "hi hi hi ";
        $this->subject = "Test Subjest ";
        $this->receiverName = "Board SO H";
    }

    /**
     * Execute the job.
     *
     * @return void
     */
    public function handle()
    {
        // $mail= new DMController;
        // $mail->handle();

        //
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
