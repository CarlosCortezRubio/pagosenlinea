<h5>
   @if (session('message') == 'user_exists')
      Ya existe una cuenta creada con este documento de identidad y correo electr&oacute;nico
      <strong>{{ hideEmail(session('email')) }}</strong>.
      <br><br>
      <a href="{{ route('login') }}" target="_blank">Inicie sesi&oacute;n</a>
      para continuar.
      <br><br>
      Si no recuerda su contrase&ntilde;a, haga clic
      <a href="{{ route('password.request') }}">aqu&iacute;</a>
      para intentar restablecerla.

   @elseif (session('message') == 'solicitud_exists')
      Ya existe una solicitud de registro con este documento de identidad.
      <br><br>
      En caso no hayas recibido ning&uacute;n mensaje con el asunto &quot;Confirma tu correo electr&oacute;nico&quot;, lo hemos enviado nuevamente al correo electr&oacute;nico
      <strong>{{ hideEmail(session('email')) }}</strong>&#59; por favor revisa tu bandeja de entrada. En algunos casos, el mensaje podr&iacute;a llegar a tu bandeja de correo no deseado, spam o promociones.
      <br><br>
      Dentro del mensaje encontrar&aacute;s un enlace para confirmar tu correo electr&oacute;nico.
      <br><br>
      <small>El mensaje enviado solo podr&aacute; ser usado hasta las {{ session('expire') }}, de lo contrario, deber&aacute;s registrarte nuevamente.</small>

   @elseif (session('message') == 'email_exists')
      Ya existe una solicitud de registro con este correo electrónico. Deber&aacute;s utilizar uno distinto.

   @elseif (session('message') == 'success')
      Te hemos enviado un mensaje a {{ hideEmail(session('email')) }}, con el asunto &quot;Confirma tu correo electr&oacute;nico&quot;&#59; por favor revisa tu bandeja de entrada. En algunos casos, el mensaje podr&iacute;a llegar a tu bandeja de correo no deseado, spam o promociones.
      <br><br>
      Dentro del mensaje encontrar&aacute;s un enlace para confirmar tu correo electr&oacute;nico.
      <br><br>
      <small>El mensaje enviado solo podr&aacute; ser usado hasta las {{ session('expire') }}, de lo contrario, deber&aacute;s registrarte nuevamente.</small>
   @endif
</h5>