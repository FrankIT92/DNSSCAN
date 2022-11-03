<!DOCTYPE html>
<html lang="en">
  <head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="description" content="">
    <meta name="author" content="HQWEB">
    <link rel="icon" href="/favicon.ico">

    <title>DNS SCANNER</title>

    <!-- Bootstrap core CSS -->
    <link href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.6/css/bootstrap.min.css" rel="stylesheet">

    <!-- Custom styles -->
    <link href="style.css" rel="stylesheet">
  </head>

  <body>


 
<div class="container">
      <div class="header clearfix">
        <nav>
          <ul class="nav nav-pills pull-left">
          	<!--<img src="https://encrypted-tbn0.gstatic.com/images?q=tbn%3AANd9GcRBxlRDuBHSA5tzQABlKuhjGiArGieDt3ycmcwhbA_dW_LG7Nyu" width="50" height="50"> -->
            <!--<li role="presentation" class="active"><a href="https://google.com">Home</a></li> -->
          </ul>
        </nav>
       		<h3 class="text-muted">DNS SCANNER</h3>
       		<p class="pull-center"><?php echo 'Your IP:'.$_SERVER['REMOTE_ADDR']; error_reporting(0); ?></p>
      </div>
      <p>Give the scan a couple of seconds to find the records</p>
      <p>Search without http parameters and www. infront of domain name</p>

	<div class="jumbotron">
		<form action="" method="post">
			<div class="form-group">
				<input class="form-control input-lg text-center" name ="domain" type="text" placeholder="<?php if(isset($_POST['submit'])) { echo($_POST['domain']); }else{echo("yourdomainhere.dk");} ?>" requirerd>
	        	<button type="submit" name="submit" class="btn btn-primary btn-lg">Lookup DNS</button>
			</div>
		</form>
	</div>

	<div class="row marketing">

		<?php

			if(isset($_POST['submit']))
					{
						$domain_regex = '/[a-z\d][a-z\-\d\.]+[a-z\d]/i';
						$domain = $_POST['domain'];
						$dns_a = dns_get_record($domain, DNS_A);
						$dns_ns = dns_get_record($domain, DNS_NS);
						$dns_cname = dns_get_record($domain, DNS_CNAME);
						$dns_mx = dns_get_record($domain, DNS_MX);
						$dns_soa = dns_get_record($domain, DNS_SOA);
						$dns_txt = dns_get_record($domain, DNS_TXT);
						$dns_aaaa = dns_get_record($domain, DNS_AAAA);
						$dns_all = dns_get_record($domain, DNS_ALL);

		?>

		<table class="table table-striped table-bordered table-responsive">
			<thead class="bg-primary">
					<td class="text-center">Record</td>
					<td class="text-center">Class</td>
					<td class="text-center">TTL</td>
					<td>Detaljer for <?php echo($_POST['domain']); ?></td> 
			</thead>
			<tr>
				<!-- Post the IP at A-record and show company handling it -->
				<td class="vert-align text-center"><h4><span class="label label-primary"><?php echo($dns_a[0]['type']); ?></span></h4></td>
				<td class="vert-align text-center"><?php echo($dns_a[0]['class']); ?></td>
				<td class="vert-align text-center"><?php echo($dns_a[0]['ttl']); ?></td>
				<td>
					<?php 
					foreach($dns_a as $value)
						{
							?>	<h4>
									<?php
										echo($value['ip']);
										//IF IP MATCHES THIS, HOST IS: WHAT EVER YOU LIKE HERE
										if($value['ip'] == "11.11.11.11"){
											echo " - RANDOM HOST HERE";
										}
										//OTHER HOST
										else if ($value['ip'] == "12.12.12.12") {
											echo " - OTHER HOST";
										}
										
					} ?>
					</h4>
				</td>
			</tr>
			<tr>
				<td class="vert-align text-center"><h4><span class="label label-danger"><?php echo($dns_mx[0]['type']); ?></span></h4></td>
				<td class="vert-align text-center"><?php echo($dns_mx[0]['class']); ?></td>
				<td class="vert-align text-center"><?php echo($dns_mx[0]['ttl']); ?></td>
				<td>
					<?php 
					foreach($dns_mx as $value)
						{
							?><h4>
								[<?php  echo($value['pri']); ?>] 
								<?php  echo($value['target']); ?>
								(<?php echo(gethostbyname($value['target'])) ?>)
								<?php if (strpos($value['target'], 'protection.outlook.com') !== false) {
									echo '</br></br><div class="blink_me">Denne kunde har office 365</div>';
									}?>
					</br>
			</h4></p>
							<?php } ?>
				</td>
			</tr>
			<?php $result_aaaa = empty($dns_aaaa); if($result_aaaa != null){ ?>
			<tr class = "warning">
				<td class="vert-align text-center"><h4>AAAA</h4></td>
				<td class="vert-align text-center">/</td>
				<td class="vert-align text-center">/</td>
				<td><h4>No AAAA record for this server (IPV6)</h4></td>
			</tr>
			<?php } else { ?>
			<tr>
				<td class="vert-align text-center"><h4><span class="label label-info"><?php echo($dns_aaaa[0]['type']); ?><?php echo($result_aaaa); ?></span></h4></td>
				<td class="vert-align text-center"><?php echo($dns_aaaa[0]['class']); ?></td>
				<td class="vert-align text-center"><?php echo($dns_aaaa[0]['ttl']); ?></td>
				<td>
					<?php 
					foreach($dns_aaaa as $value)
						{
							?><h4>
								<?php  echo($value['ipv6']); ?>
							</h4>
							<?php } ?>
				</td>
			</tr>
			<?php } ?>
			<tr>
				<td class="vert-align text-center"><h4><span class="label label-success"><?php echo($dns_ns[0]['type']); ?></span></h4></td>
				<td class="vert-align text-center"><?php echo($dns_ns[0]['class']); ?></td>
				<td class="vert-align text-center"><?php echo($dns_ns[0]['ttl']); ?></td>
				<td>
					<?php 
					foreach($dns_ns as $value)
						{
							?><h4>
								<?php  echo($value['target']); ?>
								(<?php echo(gethostbyname($value['target'])) ?>)
							</h4>
				<?php } ?>
				</td>
			</tr>
			<tr>
				<td class="vert-align text-center"><h4><span class="label label-success">Cname</span></h4></td>
				<td class="vert-align text-center">IN</td>
				<td class="vert-align text-center">3600</td>
				<td>
						<?php $www = dns_get_record("autodiscover.".$domain, DNS_CNAME);
						  //print_r($www);
						  //echo $www[0]['target'];
						while ($www[0]['target']) {
						  echo "<h4>autodiscover.".$domain."</h4>- ".$www[0]['target']."<br />";
						  $www = dns_get_record($www[0]['target'], DNS_CNAME);
						} ?>
						<br />
						<br />
				</td>
				<td>
						<?php $wwe = dns_get_record("mail.".$domain, DNS_CNAME);
						  //print_r($www);
						  //echo $www[0]['target'];
						while ($wwe[0]['target']) {
						  echo "<h4>mail.".$domain."</h4>- ".$wwe[0]['target']."<br />";
						  $wwe = dns_get_record($wwe[0]['target'], DNS_CNAME);
						} ?>
						<br />
						<br />
				</td>
			</tr>
			<tr>
				<td class="vert-align text-center"><h4><span class="label label-warning"><?php echo($dns_soa[0]['type']); ?></span></h4></td>
				<td class="vert-align text-center"><?php echo($dns_soa[0]['class']); ?></td>
				<td class="vert-align text-center"><?php echo($dns_soa[0]['ttl']); ?></td>
				<td>
						<h4>Email : <?php $email = explode(".", $dns_soa[0]['rname']); echo($email[0].'@'.$email[1].'.'.$email[2]); ?></h4>
						<h4>Serial : <?php echo($dns_soa[0]['serial']); ?></h4>
						<h4>Refresh : <?php echo($dns_soa[0]['refresh']); ?></h4>
						<h4>Retry : <?php echo($dns_soa[0]['retry']); ?></h4>
						<h4>Expire : <?php echo($dns_soa[0]['expire']); ?></h4>
						<h4>Minimum TTL : <?php echo($dns_soa[0]['minimum-ttl']); ?></h4>
				</td>
			</tr>
			<tr>
				<td class="vert-align text-center"><h4><span class="label label-default"><?php echo($dns_txt[0]['type']); ?></span></h4></td>
				<td class="vert-align text-center"><?php echo($dns_txt[0]['class']); ?></td>
				<td class="vert-align text-center"><?php echo($dns_txt[0]['ttl']); ?></td>
				<td>
				<?php
					foreach($dns_txt as $value)
						{
							?><h4 style="border: 2px solid orange;">
								<?php
									echo($value['txt']); ?>
								</h4>
						<?php } ?>
				</td>
			</tr>
			<tr>
				<!-- Check if domain is listed at spamhaus.org -->
				<td class="vert-align text-center"><h4><span class="label label-warning"><?php echo "IP ban"; ?></span></h4></td>
				<td class="vert-align text-center"><?php echo "IN"; ?></td>
				<td class="vert-align text-center"><?php echo "3600"; ?></td>
				<td>
				<?php foreach($dns_a as $value) {
							$host = $value['ip'];
							$rbl  = 'sbl-xbl.spamhaus.org';
							$rbl2 = "spamhaus.org";
							// valid query format is: 156.200.53.64.sbl-xbl.spamhaus.org
							$rev = array_reverse(explode('.', $host));
							$lookup = implode('.', $rev) . '.' . $rbl;
								if ($lookup != gethostbyname($lookup)) {
									echo"IP: $host is listed in $rbl2\n";
								} else {
									?><h4><?php echo "IP: $host NOT listed in $rbl2\n"; ?></h4><?php
								}
							}
						?>
				</td>
			</tr>
			<tr>
				<!-- Check if domain is registered at a domain handler -->
				<td class="vert-align text-center"><h4><span class="label label-success"><?php echo "Domain"; ?></span></h4></td>
				<td class="vert-align text-center"><?php echo "IN"; ?></td>
				<td class="vert-align text-center"><?php echo "NAN"; ?></td>
				<td>
				<?php
		                    if ( gethostbyname($domain) != $domain ) {
		                        echo "<h4 class='fail'>Domain in use</h4>";
		                    }
		                    else {
		                        echo "<h4 class='success'>Domain is available: <a href='godaddy.com'>Godaddy</a></h4>";
		                    }
						?>
				</td>
			</tr>
		</table>

	</div>

<?php
					}
?>

      <footer class="footer">
        <p>THIS PAGE IS HANDLED BY ME</p>
      </footer>
      	
    </div> <!-- /container -->
  </body>
</html>
