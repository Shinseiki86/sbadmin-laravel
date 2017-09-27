<?php
namespace App\Jobs;

use App\Jobs\Job;
use Illuminate\Queue\SerializesModels;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Contracts\Queue\ShouldQueue;

use Mail;

use App\Models\User;
use App\Models\Prospecto;

class SendEmailClosedTicket extends Job implements ShouldQueue
{
    use InteractsWithQueue, SerializesModels;

    private $ticket;
    private $userCloses;

    /**
     * Create a new job instance.
     *
     * @return void
     */
    public function __construct($ticket, $userCloses)
    {
        $this->ticket = $ticket;
        $this->userCloses = $userCloses;
    }

    /**
     * Execute the job.
     *
     * @return void
     */
    public function handle()
    {
        $ticket = $this->ticket;
        $userCloses = $this->userCloses;
        $view   = 'layouts.emails.info_ticket_cerrado';

        //if ($this->attempts() < 3) {
        try{
            Mail::send($view, compact('ticket'), function($message) use($ticket, $userCloses) {
                //Remitente
                $message->from(env('MAIL_USERNAME'), env('MAIL_NAME'));
                //Asunto
                $TICK_ID = str_pad($ticket->TICK_ID, 6, '0', STR_PAD_LEFT);
                $message->subject('Ticket '.$TICK_ID.' cerrado por G.H.');

                $to = [ $ticket->usuario->email, ];
                //Copia al usuario que creó el ticket y al usuario que cerró el ticket. Si es temporal, copia al responsable de la temporal.
                $cc = [ $userCloses->email ];

                $responsableTemp = $ticket->contrato->temporal;
                //Si es temporal, entonces se envía correo al responsable de la temporal.
                if(isset($responsableTemp))
                    $to[] = $responsableTemp->prospecto->PROS_CORREO;

                $responsableGH = $ticket->contrato->empleador;
                if(isset($responsableGH)){
                    //Si es temporal, entonces se envía copia al responsable del empleador.
                    if(isset($responsableTemp))
                        $cc[] = $responsableGH->EMPL_CORREO;
                    else
                        $to[] = $responsableGH->EMPL_CORREO;
                }

                $message->to($to);
                $message->cc($cc);
            });
        } catch(\Exception $e){
            flash_alert( 'Error enviando correo para ticket '.$ticket->TICK_ID'. Error: '.$e->getMessage(), 'danger' );
        }
    }
}
