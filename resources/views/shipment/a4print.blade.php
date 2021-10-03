<!DOCTYPE html>
<html>
	<head>
		<meta charset="utf-8" />
		<title>Shipment </title>
        <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
        <script src="{{ asset('/src/scripts/jquery.qrcode.min.js ') }}"></script>
		<style>
			.invoice-box {
				max-width: 100%;
				padding: 30px;
				font-size: 16px;
				line-height: 24px;
				font-family: 'Helvetica Neue', 'Helvetica', Helvetica, Arial, sans-serif;
				color: #555;
			}

			.invoice-box table {
				width: 100%;
				line-height: inherit;
				text-align: left;
			}

			.invoice-box table td {
				padding: 5px;
				vertical-align: top;
			}

			.invoice-box table tr td:nth-child(2) {
				text-align: right;
			}

			.invoice-box table tr.top table td {
				padding-bottom: 20px;
			}

			.invoice-box table tr.top table td.title {
				font-size: 45px;
				line-height: 45px;
				color: #333;
			}

			.invoice-box table tr.information table td {
				padding-bottom: 40px;
			}

			.invoice-box table tr.heading td {
				background: #eee;
				border-bottom: 1px solid #ddd;
				font-weight: bold;
			}

			.invoice-box table tr.details td {
				padding-bottom: 20px;
			}

			.invoice-box table tr.item td {
				border-bottom: 1px solid #eee;
			}

			.invoice-box table tr.item.last td {
				border-bottom: none;
			}

			.invoice-box table tr.total td:nth-child(2) {
				border-top: 2px solid #eee;
				font-weight: bold;
			}

			@media only screen and (max-width: 600px) {
				.invoice-box table tr.top table td {
					width: 100%;
					display: block;
					text-align: center;
				}

				.invoice-box table tr.information table td {
					width: 100%;
					display: block;
					text-align: center;
				}
			}

			/** RTL **/
			.invoice-box.rtl {
				direction: rtl;
				font-family: Tahoma, 'Helvetica Neue', 'Helvetica', Helvetica, Arial, sans-serif;
			}

			.invoice-box.rtl table {
				text-align: right;
			}

			.invoice-box.rtl table tr td:nth-child(2) {
				text-align: left;
			}
		</style>
	</head>

	<body>
		<div class="invoice-box">
			<table cellpadding="0" cellspacing="0">
				<tr>
					<td colspan="2" style="text-align: center">
						<img src="{{ asset('/src/images/kgsllogo.png') }}" style="max-height: 70px"/> 
					</td>

				</tr>
				<tr>
					<td colspan="2"><hr/></td>
				</tr>
				<tr class="top">
					<td colspan="2">
						<table>
							<tr>
                                <td>
									Tracking Number : {{ $shipment->traking_number }}<br />
									Created: {{ $shipment->created_at }}<br />
							
								</td>

								<td class="title">
                                    <div id="qrcode">
                                </div>
							</tr>
						</table>
					</td>
				</tr>

				<tr class="information">
					<td colspan="2">
						<table>
                            <tr>
                                <td style="padding-bottom:0px !important;"><strong>Sender Info</strong></td>
                                <td style="padding-bottom:0px !important;"><strong>Recipient Info</strong></td>
                            </tr>
							<tr>
								<td>
									{{ $shipment->Agent->name }}<br />
									{{ $shipment->Agent->website }} <br />
                                    {{ $shipment->Agent->telephone }} <br />
                                    {{ $shipment->Agent->country }}, {{ $shipment->Agent->address }} 
								</td>

								<td>
									{{ $shipment->customer_name }}<br />
									{{ $shipment->customer_telephone }}<br />
									{{ $shipment->customer_country }}, {{ $shipment->customer_state }}, {{ $shipment->customer_region }}, {{ $shipment->customer_city }}<br />
                                    {{ $shipment->customer_directions }}
								</td>
							</tr>
						</table>
					</td>
				</tr>


				<tr class="heading">
					<td>Billing</td>

					<td></td>
				</tr>


				<tr class="item last">
					<td>Total</td>

					<td> {{ $shipment->Currency->left_symbole }} {{ $shipment->FormatedAmount }} {{ $shipment->Currency->right_symbole }}</td>
				</tr>

	
			</table>
            <hr>
            <table style="border: 1px solid #333333;">
                <tr>
                    <td style="text-align: left !important;"><strong>Sender Comment:</strong> {{ $shipment->agent_comment }}</td>
                </tr>
                <tr>
                    <td style="text-align: left !important;"><strong>Recipient Comment:</strong> {{ $shipment->customer_comment }}</td>
                </tr>
            </table>
		</div>
        <script type="text/javascript">
            $('#qrcode').qrcode({width: 90,height: 90,text: "Hello Word!"});

        </script>
	</body>
</html>