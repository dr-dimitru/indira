<!doctype html>
<html lang="{{ $lang }}" style="padding:10px 0px;margin:0px;width:100%;background-color:#ececec;">
<head>
	<meta charset="utf-8">
	<meta http-equiv="X-UA-Compatible" content="IE=edge,chrome=1">
	<title>{{ $subject }}</title>
	<meta name="viewport" content="width=device-width">
	<style type="text/css">
		html{font-size:100%;-webkit-text-size-adjust:100%;-ms-text-size-adjust:100%}::-moz-selection{background:rgba(0,0,0,0.2);color:#fff;text-shadow:none}::selection{background:rgba(0,0,0,0.2);color:#fff;text-shadow:none}a:focus{outline:0}a:hover,a:active{outline:0}abbr[title]{border-bottom:1px dotted}b,strong{font-weight:bold}small{font-size:85%}sub,sup{font-size:75%;line-height:0;position:relative;vertical-align:baseline}sup{top:-0.5em}sub{bottom:-0.25em}ul,ol{margin:1em 0;padding:0 0 0 40px}table{border-collapse:collapse;border-spacing:0}td{vertical-align:top}body{font-family:"Lucida Grande",Helvetica,Arial,Verdana,sans-serif;font-size:13px;color:#2b2b2b;line-height:20px;background-color:#ececec;text-shadow:1px 1px rgba(255,255,255,.95)}.wrapper{max-width:546px;margin:26px auto;background-color:#fafafa;-webkit-border-radius:6px;-moz-border-radius:6px;border-radius:6px;box-shadow:0px 1px 1px #ccc;box-shadow:0px 1px 5px rgba(0, 0, 0, 0.1);padding:5px;border:1px solid rgba(0,0,0,0.2);}a,a:visited{color:#b0b3b9}a:hover{color:#b0b3b9}.footer{text-align:center;font-size:11px;color:#b0b3b9;line-height:14px;text-shadow:1px 1px #fff;text-shadow:1px 1px rgba(255,255,255,.5)}.footer a,.footer a:visited{color:#b0b3b9;font-weight:bold}.main{padding:15px;-webkit-border-radius:8px;-moz-border-radius:8px;border-radius:8px;box-shadow:inset 0px 0px 1px #ccc;box-shadow:inset 0px 0px 1px rgba(0,0,0,0.4);border:1px solid rgba(0,0,0,0.2);}h2{font-weight:200; color:#222;}hr{display:block;height:1px;border:0;border-top:1px solid #ccc;border-top:1px solid rgba(0,0,0,0.2);margin:1em -16px;padding:0}
	</style>
</head>
<body style="padding:10px 0px;margin:0px;width:100%;background-color:#ececec;">
	<div style="font-family:'Lucida Grande',Helvetica,Arial,Verdana,sans-serif;font-size:13px;color:#2b2b2b;line-height:20px;background-color:#ececec;text-shadow:1px 1px rgba(255,255,255,.95);">
		<div class="wrapper" style="max-width:546px;margin:26px auto;background-color:#fafafa;-webkit-border-radius:6px;-moz-border-radius:6px;border-radius:6px;box-shadow:0px 1px 1px #ccc;box-shadow:0px 1px 5px rgba(0, 0, 0, 0.1);padding:5px;border:1px solid rgba(0,0,0,0.2);">
			<div class="main" style="padding:15px;-webkit-border-radius:8px;-moz-border-radius:8px;border-radius:8px;box-shadow:inset 0px 0px 1px #ccc;box-shadow:inset 0px 0px 1px rgba(0,0,0,0.4);border:1px solid rgba(0,0,0,0.2);">
				<table bgcolor="fafafa" font-color="2b2b2b" width="100%" cellspacing="0" celladding="0" border="0">
					<tbody>
						<tr>
							<td>
								<h2 style="font-weight:200">{{ $subject }}</h2>
								<hr style="display:block;height:1px;border:0;border-top:1px solid #ccc;border-top:1px solid rgba(0,0,0,0.2);margin:1em -16px;padding:0">
							</td>
						</tr>
						<tr>
							<td>
								<p>{{ $message }}</p>
							</td>
						</tr>
					</tbody>
				</table>
			</div>
		</div>
		<div class="footer" align="center" width="100%" style="text-align:center;font-size:11px;color:#b0b3b9;line-height:14px;text-shadow:1px 1px #fff;text-shadow:1px 1px rgba(255,255,255,.5)">
			<table bgcolor="ececec" color="b0b3b9" height="100%" width="100%" cellspacing="0" celladding="0" border="0">
				<tbody>
					<tr>
						<td>
							All rights belongs to site owner.<br />
							<a style="color:#b0b3b9;font-weight:bold" href="{{ URL::base() }}">{{ Config::get('indira.name') }}</a>
						</td>
					</tr>
				</tbody>
			</table>
		</div>
	</div>
</body>
</html>