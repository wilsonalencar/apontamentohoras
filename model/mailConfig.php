<?php
// require_once('PHPMailer/PHPMailer.php');

// $mail = new PHPMailer();
// Define os dados do servidor e tipo de conexão
// =-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=
// $mail->IsSMTP(); // Define que a mensagem será SMTP
// $mail->Host = "smtp.gmail.com"; // Endereço do servidor SMTP
// $mail->Port = 587;

// Define o remetente
// =-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=
// $mail->From = "lucas.saboreweb@gmail.com"; // Seu e-mail
// $mail->FromName = "Lucas"; // Seu nome
// $mail->SMTPSecure = 'tls';
// $mail->SMTPAuth = true;
// $mail->Username = "lucas.saboreweb@gmail.com";
// $mail->Password = "";

// Define os destinatário(s)
// =-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=
// $mail->addAddress("lucas.saboreweb@gmail.com", "Alura Curso PHP e MySQL");
// $mail->addAddress("lucas.saboreweb@gmail.com");
//$mail->AddCC('ciclano@site.net', 'Ciclano'); // Copia
//$mail->AddBCC('fulano@dominio.com.br', 'Fulano da Silva'); // Cópia Oculta

// Define os dados técnicos da Mensagem
// =-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=
// $mail->IsHTML(true); // Define que o e-mail será enviado como HTML
//$mail->CharSet = 'iso-8859-1'; // Charset da mensagem (opcional)

// Define a mensagem (Texto e Assunto)
// =-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=
// $mail->Subject  = "Mensagem Teste"; // Assunto da mensagem
// $mail->Body = "Este é o corpo da mensagem de teste, em <b>HTML</b>!  :)";
// $mail->AltBody = "Este é o corpo da mensagem de teste, em Texto Plano! \r\n :)";

// Define os anexos (opcional)
// =-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=
//$mail->AddAttachment("c:/temp/documento.pdf", "novo_nome.pdf");  // Insere um anexo

// Envia o e-mail
// $enviado = $mail->Send();

// // Limpa os destinatários e os anexos
// $mail->ClearAllRecipients();
// $mail->ClearAttachments();

// // Exibe uma mensagem de resultado
// if ($enviado) {
//   echo "E-mail enviado com sucesso!";
// } else {
//   echo "Não foi possível enviar o e-mail.";
//   echo "<b>Informações do erro:</b> " . $mail->ErrorInfo;
// }


?>
