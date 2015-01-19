<?php
	function curl_delete($url,$headers)
	{
	    $ch = curl_init();
    	curl_setopt($ch, CURLOPT_URL,$url);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER,TRUE);
        curl_setopt($ch, CURLOPT_CONNECTTIMEOUT,5);
    	curl_setopt($ch, CURLOPT_CUSTOMREQUEST, "DELETE");
		curl_setopt($ch, CURLOPT_HTTPHEADER, $headers);		
        curl_setopt($ch, CURLOPT_FOLLOWLOCATION, TRUE);
        curl_setopt($ch, CURLOPT_AUTOREFERER, TRUE);
        curl_setopt($ch, CURLOPT_TIMEOUT, 10);
        curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, FALSE);

    	$result = curl_exec($ch);
    	$httpCode = curl_getinfo($ch, CURLINFO_HTTP_CODE);
    	curl_close($ch);
		return $httpCode;

	}
    
	function curl($url,$post="")
    {
        $curl = curl_init();
        curl_setopt($curl,CURLOPT_URL,$url);
        curl_setopt($curl,CURLOPT_RETURNTRANSFER,TRUE);
        curl_setopt($curl,CURLOPT_CONNECTTIMEOUT,5);
        if($post!="")
        {
            curl_setopt($curl,CURLOPT_POST,5);
            curl_setopt($curl,CURLOPT_POSTFIELDS,$post);
        }
        curl_setopt($curl, CURLOPT_FOLLOWLOCATION, TRUE);
        curl_setopt($curl, CURLOPT_AUTOREFERER, TRUE);
        curl_setopt($curl, CURLOPT_TIMEOUT, 10);
        curl_setopt($curl, CURLOPT_SSL_VERIFYPEER, FALSE);

        $contents = curl_exec($curl);
        curl_close($curl);
        return $contents;
    }

	function printData($temp,$accesstoken)
	{
		?>
        <p class="">
			<?php echo $temp['feed']['title']['$t'];?>
           (<?php echo $temp['feed']['openSearch$totalResults']['$t'];?>)
        </p> 
        <p class="">
        	<?php $email=$temp['feed']['id']['$t']; echo $email;?>
        </p>
        <section class=""> 
        	<table border="1" cellpadding="5" style="font-size:14px;">
            	<thead>
                	<tr>
                    	<th>#</th>
                        <td>id</td>
                        <th>Name</th>
                        <th>Email</th>
                        <th>Number</th>
                        <th>Address</th>
                        <th></th>
                    </tr>
                </thead>
                <tbody>
                	<?php 
					$j=0;
					foreach($temp['feed']['entry'] as $c){
						$j++;
						$cid='';
						$etag=$c['gd$etag'];
					?>
                    	<tr id="contact-<?php echo $j;?>">
                        	<td><?php echo $j;?></td>
                            <td><?php 
								$temp=explode('/',$c['id']['$t']);
								$cid=end($temp);
								echo $cid;?>
                            </td>
                            <td>
                            <?php
								foreach($c['link'] as $l){
									if($l['type']=='image/*')
									{
										echo '<img src="'.$l['href'].'&access_token='.$accesstoken.'" class="thumb-xs" onerror="di(this)">';
										break;
									}
								}
                            ?>
                            <?php 
								if(array_key_exists('gd$name',$c))
									echo $c['gd$name']['gd$fullName']['$t'];
							?>
                            </td>
                            <td><?php 
								$i=0;
								if(array_key_exists('gd$email',$c))
								foreach($c['gd$email'] as $n){echo $n['address']."<br>";}
								?>
                            </td>
                            <td><?php $i=0;
								if(array_key_exists('gd$phoneNumber',$c))
								foreach($c['gd$phoneNumber'] as $n){echo $n['$t']."<br>";}
							?>
                            </td>
                            <td><?php $i=0;
								if(array_key_exists('gd$structuredPostalAddress',$c))
								foreach($c['gd$structuredPostalAddress'] as $n){
									echo $n['gd$formattedAddress']['$t']."<br>";
								}
								?>
                            </td>
                            <td>
                            <a href="#" onClick="del(<?php echo $j.",'".urlencode($email)."','".urlencode($cid)."','".urlencode($etag)."'";?>)">Delete</a>
                            </td>
                        </tr>
                        <?php }?>
                    </tbody>
                 </table>
             </section> 
        <?php
	}
?>