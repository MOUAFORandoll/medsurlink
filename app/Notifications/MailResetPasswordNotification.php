<?php

namespace App\Notifications;

use App\Http\Controllers\Traits\PersonnalErrors;
use App\User;
use Carbon\Carbon;
use Illuminate\Bus\Queueable;
use Illuminate\Notifications\Notification;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Support\Facades\Lang;

class MailResetPasswordNotification extends Notification
{
    use Queueable;
    use PersonnalErrors;
    public $token;
    /**
     * Create a new notification instance.
     *
     * @return void
     */
    public function __construct($token)
    {
        $this->token = $token;
    }

    /**
     * Get the notification's delivery channels.
     *
     * @param  mixed  $notifiable
     * @return array
     */
    public function via($notifiable)
    {
        return ['mail'];
    }

    /**
     * Get the mail representation of the notification.
     *
     * @param  mixed  $notifiable
     * @return \Illuminate\Notifications\Messages\MailMessage
     */
    public function toMail( $notifiable ) {

        $email = $notifiable->getEmailForPasswordReset();
        $env = strtolower(config('app.env'));
        $online = "";
        if ($env == 'local')
            $online = config('app.url_loccale');
        else if ($env == 'staging')
            $online = config('app.url_stagging');
        else
            $online = config('app.url_prod');
        $date = Carbon::now();
        $mail = new MailMessage;
        $users = User::whereEmail($email)->get();


        foreach ($users as $key => $user){
            if ($user->getRoleNames()->first() == 'Patient'){
                if (is_null($user->patient)){
                    $users->forget($key);
                }
            }
            else if ($user->getRoleNames()->first() == 'Souscripteur'){
                if (is_null($user->souscripteur)){
                    $users->forget($key);
                }
            }else if ($user->getRoleNames()->first() == 'Gestionnaire'){
                if (is_null($user->gestionnaire)){
                    $users->forget($key);
                }
            }else if ($user->getRoleNames()->first() == 'Praticien'){
                if (is_null($user->praticien)){
                    $users->forget($key);
                }
            }else if ($user->getRoleNames()->first() == 'Medecin controle'){
                if (is_null($user->medecinControle)){
                    $users->forget($key);
                }
            }
        }
        if (count($users)>0) {
            $token = $this->token;
            $mail->from(config('mail.from.address'));
            $mail->subject(Lang::getFromJson('Reset Password Notification'));
            $mail->line(Lang::getFromJson('You are receiving this email because we received a password reset request for your account.'));

            //        if (count($users) == 1 ){
//            $mail->action(Lang::getFromJson('Reset Password'), url($local.'/password/reset/'.$this->token.'/email/'.$email));
//        }else{
//            $mail->line(Lang::getFromJson('You have many accounts link to your Email. Please choose account you want to update'));
//            foreach ($users as $user){
//
//                $mail->line(Lang::getFromJson($user->getRoleNames()->first()));
//                $mail->line(Lang::getFromJson('Reset Password '.strtoupper($user->nom).' '.ucfirst($user->prenom)));
//                $mail->action('dgdf',url($local.'/password/reset/'.$this->token.'/'.$user->slug));
//            }
//        }

            $mail->view('emails.password.reset', compact('users', 'email', 'online', 'token', 'date'));
//        $mail->line(Lang::getFromJson('This password reset link will expire in :count minutes.', ['count' => config('auth.passwords.'.config('auth.defaults.passwords').'.expire')]));
//        $mail->line(Lang::getFromJson('If you did not request a password reset, no further action is required.'));
//
            return $mail;
        }else{
         $this->revealError('email','This user account has been deleted');
        }
    }

    /**
     * Get the array representation of the notification.
     *
     * @param  mixed  $notifiable
     * @return array
     */
    public function toArray($notifiable)
    {
        return [
            //
        ];
    }
}
