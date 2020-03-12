# Medsurlink
<p>You are receiving this email because we received a password reset request for your account.</p>
@if (count($users) == 1 )
<a href="{{url($online.'/password/reset/'.$token.'/'.$users[0]->slug)}}">{{$users[0]->getRoleNames()->first()}} : {{strtoupper($users[0]->nom).' '.ucfirst($users[0]->prenom)}}</a><br>
@else
<p>You have many accounts link to your Email. Please choose account you want to update</p>
@foreach ($users as $user)
<a href="{{url($online.'/password/reset/'.$token.'/'.$user->slug)}}">{{$user->getRoleNames()->first()}} : {{strtoupper($user->nom).' '.ucfirst($user->prenom)}}</a><br>
@endforeach
@endif
<p>This password reset link will expire in {{config('auth.passwords.'.config('auth.defaults.passwords').'.expire')}} minutes.</p>
<p>If you did not request a password reset, no further action is required.</p>


