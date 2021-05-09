<?php
#blast Search main
?>

<!DOCTYPE html>
<html>
<head> 
<title>BLAST</title>
<style>
/* Note: This CSS will style all instances of 
   <input type=file /> controls in your website. */
input[type="file"],
input[type="file"]:visited,
input[type="file"]:hover,
input[type="file"]:focus,
input[type="file"]:active {
    margin:0;
    padding: 0em 0em;
    padding: 0rem 0rem;
    overflow: hidden; /* long file names overflow so just hide the end */
    background: #ffffff;
    border-radius: .2em;
    border-radius: .2rem;
    outline: none;
    border: 2px solid #bbb;
    cursor: pointer;
    -webkit-appearance: textfield;
    -moz-appearance: textfield;
}

input[type="file"]:hover {
    background: #f9f9ff; /* I am using a light blue to indicate an interaction */
    border: 2px solid #999;
}

input[type="file"]:visited,
input[type="file"]:focus,
input[type="file"]:active {
    background: #fff; /* Default back to white when focused. */
    border: 2px solid #999;
}

/* Note: Firefox flags the file name box as a *readonly* input. So that attribute selector was added below. Note: These selectors blow up in IE so have to be separated from the same styles above. */
input[type="file"]:disabled,
input[type="file"]:read-only {
    margin: 0;
    padding: 0em 0em;
    padding: 0rem 0rem;
    overflow: hidden; /* long file names overflow so just hide the end */
    background: #ffffff;
    border-radius: .2em;
    border-radius: .2rem;
    outline: none;
    border: 2px solid #bbb;
    cursor: pointer;
    -webkit-appearance: textfield;
    -moz-appearance: textfield;
}

input[type="file"]:disabled:hover,
input[type="file"]:read-only:hover {
    background: #f9f9ff; /* I am using a light blue to indicate an interaction */
    border: 2px solid #999;
}

input[type="file"]:disabled:visited,
input[type="file"]:disabled:focus,
input[type="file"]:disabled:active,
input[type="file"]:read-only:visited,
input[type="file"]:read-only:focus,
input[type="file"]:read-only:active {
    background: #fff; /* Default back to white when focused. */
    border: 2px solid #999;
}

/* IE UPLOAD BUTTON STYLE: This attempts to alter the file upload button style in IE.  Keep in mind IE gives you limited design control but at least you can customize its upload button.*/
::-ms-browse { /* IE */
    display: inline-block;
    margin: 0;
    padding: .3em .5em;
    padding: .2rem .5rem;
    text-align: center;
    outline: none;
    border: none;
    background: #3B8442;
    white-space: nowrap;
    cursor: pointer;
}
/* FIREFOX UPLOAD BUTTON STYLE */
::file-selector-button {/* firefox */
    display: inline-block;
    margin: 0rem 1rem 0rem 0rem;
    padding: .18em .5em;
    padding: .18rem .5rem;
    -webkit-appearance: button;
    text-align: center;
    border-radius: .1rem 0rem 0rem .1rem;
    outline: none;
    border: none;
    border-right: 2px solid #bbb;
    background: #eee;
    white-space: nowrap;
    cursor: pointer;
}
/* CHROME AND EDGE UPLOAD BUTTON STYLE */
::-webkit-file-upload-button { /* chrome and edge */
    display: inline-block;
    margin: 0rem 1rem 0rem 0rem;
    padding: .19em .5em;
    padding: .19rem .5rem;
    -webkit-appearance: button;
    text-align: center;
    border-radius: .1rem 0rem 0rem .1rem;
    outline: none;
    border: none;
    border-right: 2px solid #bbb;
    background: #eee;
    white-space: nowrap;
    cursor: pointer;
}
</style>

<link href="stylesheets/blast.css"  rel="Stylesheet" type="text/css" />
<script type="text/javascript" src='javascripts/blast.js'></script>

</head>
<body>
   
	
	<div class="spacer">&nbsp;</div>
    
    <div id="indent">

<form enctype='multipart/form-data' name='blastForm' action = 'blastresult.php' method='post'>
<div class='box'>
	<div id="title">
		<center><strong>BLAST Search</strong></center>
	</div>

<center><p>Enter query sequences here  Fasta format.</p> 
<br>
<br>

<p><textarea name='querySeq' rows='6' cols='66'></textarea></p>
<br>
<br>

<p>Or upload sequence fasta file:</p>

	 <input type='file' name='queryfile' class="inputf" data-height="60">
<p><table border=0 style='font-size: 20px'>
<tr><td valign=top>
Program <select id="programList" name='program' font-size ='large' onchange="changeDBList(this.value, this.form.dbList, dblib[programNode.value]); changeParameters(this.value, 'adv_parameters');">
<option value='blastn' selected>blastn
<option value='blastp'>blastp
<option value='blastx'>blastx
<option value='tblastn'>tblastn
<option value='tblastx'>tblastx
</select></td>

<td valign=top>&nbsp;&nbsp;&nbsp;
Database(s)
</td><td></center>
<?php
$fp = fopen ("./blast.ini", "r");
if(!$fp) {
	echo "<p><strong> Error: Couldn't open file blast.ini </strong></p></body></html>";
	exit;
}
while(!feof($fp)) {
	$blastdbstring = rtrim(fgets($fp));
	if (!$blastdbstring) {
		continue;
	}
	if (!preg_match("/^\s*#/", $blastdbstring)) {
		$blastdbArray = preg_split('/:/', $blastdbstring);	
		$blastProgram = $blastdbArray[0];
		$dbString = $blastdbArray[1];
		
		if ($blastProgram == "blast+") {
			echo "<input type='hidden' name= 'blastpath' value='$dbString'>";
		}else {
			if (preg_match("/^\s*(.*?)\s*$/", $blastProgram, $match)) {
				$blastProgram = $match[1];
			}
			if (preg_match("/^\s*(.*?)(\s*|\s*,\s*)$/", $dbString, $match)) {
				$dbString = $match[1];
			}
			$dbString = preg_replace("/\s*=>\s*/", "=>", $dbString);
			if (preg_match("/,/", $dbString, $match)) {
				$dbString = preg_replace("/\s*,\s*/", ",", $dbString);
			}		
			echo "<input id='$blastProgram' type='hidden' name='blastdb[]' value='$dbString'>";
		}
	}	
}
fclose($fp);
#Creeated by Ankush Sharma
?>
<select id="dbList" size=4 multiple="multiple" name ="patientIDarray[]">
<script type="text/javascript">
	var dblib = Array();
	var programNode = document.getElementById("programList");
	var blastndbNode = document.getElementById("blastn");
	var blastpdbNode = document.getElementById("blastp");
	var blastxdbNode = document.getElementById("blastx");
	var tblastndbNode = document.getElementById("tblastn");
	var tblastxdbNode = document.getElementById("tblastx");
	dblib["blastn"] = blastndbNode.value;
	dblib["blastp"] = blastpdbNode.value;
	dblib["blastx"] = blastxdbNode.value;
	dblib["tblastn"] = tblastndbNode.value;
	dblib["tblastx"] = tblastxdbNode.value;
	changeDBList(programNode.value, document.getElementById("dbList"), dblib[programNode.value]);
</script>



</select>
</td></tr></table></p>

<p>And/or upload sequence fasta file:</p>
	
<input type='file' name='blastagainstfile'>

<input type='hidden' name='blast_flag' value=1>

<p><input type='button' class = 'blastg' name="bblast" value='Search' onclick="checkform(this.form, this.value)">&nbsp;&nbsp;<input type='reset' class = 'blastg' value='Reset' onclick="window.location.reload();"></p>


</form>

</div>
</div>

</body>
</html>
