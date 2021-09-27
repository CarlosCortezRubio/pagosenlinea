
<!DOCTYPE html>
<html lang="es" dir="ltr">
   <head>
      <meta charset="utf-8">
      <title>Correo electrónico</title>
   </head>
   <body>
      <table width="100%">
         <tbody>
            <!-- Logo -->
            <tr style="background-color:#F7F7F7;">
               <td style="font-family: -apple-system, BlinkMacSystemFont, 'Segoe UI', Roboto, Helvetica, Arial, sans-serif, 'Apple Color Emoji', 'Segoe UI Emoji', 'Segoe UI Symbol'; box-sizing: border-box; padding: 25px 0; text-align: center;">
                  <img src="{{asset('img/logo_cnm.png')}}" width="250">
               </td>
            </tr>

            <!-- Email Body -->
            <tr>
               <td width="80%" cellpadding="0" cellspacing="0" style="font-family: -apple-system, BlinkMacSystemFont, 'Segoe UI', Roboto, Helvetica, Arial, sans-serif, 'Apple Color Emoji', 'Segoe UI Emoji', 'Segoe UI Symbol'; box-sizing: border-box; background-color: #ffffff; border-bottom: 1px solid #edeff2; border-top: 1px solid #edeff2; margin: 0; padding: 0; width: 80%; -premailer-cellpadding: 0; -premailer-cellspacing: 0; -premailer-width: 80%;">
                  <table class="inner-body" align="center" width="80%" cellpadding="0" cellspacing="0" role="presentation" style="font-family: -apple-system, BlinkMacSystemFont, 'Segoe UI', Roboto, Helvetica, Arial, sans-serif, 'Apple Color Emoji', 'Segoe UI Emoji', 'Segoe UI Symbol'; box-sizing: border-box; background-color: #ffffff; margin: 0 auto; padding: 0; width: 80%; -premailer-cellpadding: 0; -premailer-cellspacing: 0; -premailer-width: 80%;">
                     <!-- Body content -->
                     <tbody>
                        <tr>
                           <td style="font-family: -apple-system, BlinkMacSystemFont, 'Segoe UI', Roboto, Helvetica, Arial, sans-serif, 'Apple Color Emoji', 'Segoe UI Emoji', 'Segoe UI Symbol'; box-sizing: border-box; color: #3d4852;">

                              <h1 style="font-size: 19px; font-weight: bold; margin-top:35px; text-align: left;">
                                 @yield('title')
                              </h1>

                              <p style="font-size: 16px; line-height: 1.5em; margin-top: 0; text-align: left;">
                                 @yield('content')
                              </p>

                           </td>
                        </tr>
                     </tbody>

                     <!-- Firma y confidencialidad -->
                     <tbody>
                        <tr>
                           <td>
                             <p>&nbsp;</p>
                             <p style="font-family: -apple-system, BlinkMacSystemFont, 'Segoe UI', Roboto, Helvetica, Arial, sans-serif, 'Apple Color Emoji', 'Segoe UI Emoji', 'Segoe UI Symbol'; box-sizing: border-box; color: #3d4852; font-size: 16px; line-height: 1.5em; margin-top: 0; text-align: left;">
                                @yield('signature')
                             </p>
                             <table class="subcopy" width="100%" cellpadding="0" cellspacing="0" role="presentation" style="font-family: -apple-system, BlinkMacSystemFont, 'Segoe UI', Roboto, Helvetica, Arial, sans-serif, 'Apple Color Emoji', 'Segoe UI Emoji', 'Segoe UI Symbol'; box-sizing: border-box; border-top: 1px solid #edeff2; margin-top: 25px; padding-top: 25px;">
                               <tbody>
                                 <tr>
                                   <td style="font-family: -apple-system, BlinkMacSystemFont, 'Segoe UI', Roboto, Helvetica, Arial, sans-serif, 'Apple Color Emoji', 'Segoe UI Emoji', 'Segoe UI Symbol'; box-sizing: border-box;">
                                     <p style="font-family: -apple-system, BlinkMacSystemFont, 'Segoe UI', Roboto, Helvetica, Arial, sans-serif, 'Apple Color Emoji', 'Segoe UI Emoji', 'Segoe UI Symbol'; box-sizing: border-box; color: #3d4852; line-height: 1.5em; margin-top: 0; margin-bottom: 35px; text-align: left; font-size: 12px;">Este mensaje se encuentra dirigido exclusivamente para uso del destinatario previsto y contiene información confidencial y/o privilegiada. Si usted no es el destinatario al que se dirigió el mensaje, se le notifica por este medio que la divulgación, copia, distribución o cualquier actividad tomada a partir del contenido de este mensaje se encuentra terminantemente prohibida y es sancionada por la ley. Si usted ha recibido este mensaje por error por favor proceda a eliminarlo y notificar inmediatamente al remitente.</p>
                                   </td>
                                 </tr>
                               </tbody>
                             </table>
                           </td>
                        </tr>
                     </tbody>
                  </table>
               </td>
            </tr>

            <!-- Copyright -->
            <tr style="background-color:#F7F7F7;">
               <td style="font-family: -apple-system, BlinkMacSystemFont, 'Segoe UI', Roboto, Helvetica, Arial, sans-serif, 'Apple Color Emoji', 'Segoe UI Emoji', 'Segoe UI Symbol'; box-sizing: border-box;">
                  <table class="footer" align="center" width="80%" cellpadding="0" cellspacing="0" role="presentation" style="font-family: -apple-system, BlinkMacSystemFont, 'Segoe UI', Roboto, Helvetica, Arial, sans-serif, 'Apple Color Emoji', 'Segoe UI Emoji', 'Segoe UI Symbol'; box-sizing: border-box; margin: 0 auto; padding: 0; text-align: center; width: 80%; -premailer-cellpadding: 0; -premailer-cellspacing: 0; -premailer-width: 80%;">
                     <tbody>
                        <tr>
                           <td class="content-cell" align="center" style="font-family: -apple-system, BlinkMacSystemFont, 'Segoe UI', Roboto, Helvetica, Arial, sans-serif, 'Apple Color Emoji', 'Segoe UI Emoji', 'Segoe UI Symbol'; box-sizing: border-box; padding: 35px;">
                              <p style="font-family: -apple-system, BlinkMacSystemFont, 'Segoe UI', Roboto, Helvetica, Arial, sans-serif, 'Apple Color Emoji', 'Segoe UI Emoji', 'Segoe UI Symbol'; box-sizing: border-box; line-height: 1.5em; margin-top: 0; color: #aeaeae; font-size: 12px; text-align: center;">&copy; 2019 Conservatorio Nacional de Música. Todos los derechos reservados.</p>
                           </td>
                        </tr>
                     </tbody>
                  </table>
               </td>
            </tr>
         </tbody>
      </table>
   </body>
</html>
