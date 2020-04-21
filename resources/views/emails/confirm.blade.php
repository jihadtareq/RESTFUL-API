Hello {{$user->name}}

You changed your email, so we need to verify this new address. Please use the button below: 

{{route('verify', $user->verification_token)}}