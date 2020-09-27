 $url = 'https://api.sendgrid.com/';
        $sender_email = 'info@thefashionenterprise.com';   // sender's mail
        $user = 'bhutyaa_rahul';      // sendgrid username
        $pass = 'rahul@123';      // sendgrid password
        //$body = '<h1>Verification Mail</h1><br> '
        //       . 'Click on: <a href="http://webdevelopersindia.com/fbc/update.php?pro_register='.$name.'">ACTIVATE</a> to activaye your account'; //body of email

        $body = "<div marginwidth='0' marginheight='0'>
    	<div dir='ltr' style='background-color:#f5f5f5;margin:0;padding:70px 0 70px 0;width:100%'>
        	<table border='0' cellpadding='0' cellspacing='0' height='100%' width='100%'>
				<tbody><tr>
					<td align='center' valign='top'>
						<div>
	                		<p style='margin-top:0'><img src='" . SERVER_URL . "/image/home/Fashion-Enterprise-l.jpg' alt='' style='border:none;display:inline;font-size:14px;font-weight:bold;min-height:auto;line-height:100%;outline:none;text-decoration:none;text-transform:capitalize' class='CToWUd'></p>
						</div>
                    	
						<table border='0' cellpadding='0' cellspacing='0' width='600' style='background-color:#fdfdfd;border:1px solid #dcdcdc;border-radius:3px!important'>
							<tbody><tr>
								<td align='center' valign='top'>
                                    
                                	<table border='0' cellpadding='0' cellspacing='0' width='600'>
										<tbody><tr>
											<td valign='top' style='background-color:#fdfdfd'>
                                                
												<table border='0' cellpadding='20' cellspacing='0' width='100%'>
													<tbody><tr>
														<td valign='top' style='padding:48px'>
															<div style='color:#737373;font-family:&quot;Helvetica Neue&quot;,Helvetica,Roboto,Arial,sans-serif;font-size:14px;line-height:150%;text-align:left'>

																<h2 style='color:#557da1;display:block;font-family:&quot;Helvetica Neue&quot;,Helvetica,Roboto,Arial,sans-serif;font-size:18px;font-weight:bold;line-height:130%;margin:16px 0 8px;text-align:left'>Dear Sir/Madam,</h2>
																<p style='margin:0 0 16px;'>Thank You for Registering in FBC.</p>
																<p style='margin:0 0 16px;'>Now you can login on your dashboard.</p>

															</div>
														</td>
                                                    </tr></tbody>
												</table>

											</td>
                                        </tr></tbody>
									</table>

								</td>
                            </tr>
							<tr>
								<td align='center' valign='top'>
                                    
                                <table border='0' cellpadding='10' cellspacing='0' width='600'>
									<tbody><tr>
										<td valign='top' style='padding:0'>
                                                
												<table border='0' cellpadding='10' cellspacing='0' width='100%'>
													<tbody><tr>
														<td colspan='2' valign='middle' style='padding:0 48px 48px 48px;border:0;color:#99b1c7;font-family:Arial;font-size:12px;line-height:125%;text-align:center'>
															<p>This e-mail was sent from The Fashion Entreprise.</p>
														</td>
                                                    </tr></tbody>
												</table>
										</td>
                                    </tr></tbody>
								</table>

								</td>
                            </tr>
							</tbody>
						</table>
					
					</td>
                </tr></tbody>
			</table>
		</div>
</div>";
        $params = array(
            'api_user' => $user,
            'api_key' => $pass,
            'to' => $email_id, //receiver's email id
            //'to' => 'rahul0003bhutekar@gmail.com',       //receiver's email id
            'cc' => '',
            'subject' => 'User Registration Confirmation ',
            'html' => $body,
            'from' => $sender_email,
        );


        //print_r($params);

        $request = $url . 'api/mail.send.json';

        // Generate curl request
        $session = curl_init($request);

        // Tell curl to use HTTP POST
        curl_setopt($session, CURLOPT_POST, true);

        // Tell curl that this is the body of the POST
        curl_setopt($session, CURLOPT_POSTFIELDS, $params);

        // Tell curl not to return headers, but do return the response
        curl_setopt($session, CURLOPT_HEADER, false);
        // Tell PHP not to use SSLv3 (instead opting for TLS)
        curl_setopt($session, CURLOPT_SSLVERSION, CURL_SSLVERSION_TLSv1_2);
        curl_setopt($session, CURLOPT_RETURNTRANSFER, true);

        // obtain response
        $response = curl_exec($session);
        curl_close($session);