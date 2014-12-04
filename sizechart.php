<?php 
$cat=$_REQUEST['type'];
//echo 'size chart id=================='.$cat;
//exit;
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>Do u Speak Green</title>
<style type="text/css">
body {
	margin-left: 0px;
	margin-top: 0px;
	margin-right: 0px;
	margin-bottom: 0px;
}
</style>
<link href="douspeak-style.css" rel="stylesheet" type="text/css" />
</head>
<body>
<table width="500px" border="0" cellspacing="0" cellpadding="0" bgcolor="#c1c683">
  <?php if($cat=="M") { ?>
  <tr>
    <td><table  border=0 cellpadding=5 cellspacing=1  width="500"> 
 <tr >
  <td height="30" colspan="6" bgcolor="#41c1cd"  class="pro-descrip">Men's Size Chart</td>
 </tr>
 <tr  class="content">
  <td rowspan="2" class="content"  ><strong>Measurement in cm</strong></td>
  <td colspan="5" align="center" valign="middle"  ><strong>Size</strong></td>
 </tr>
 <tr  class="content">
  <td align="center" valign="middle"  ><strong>S</strong></td>
  <td align="center" valign="middle"  ><strong>M</strong></td>
  <td align="center" valign="middle" ><strong>L</strong></td>
  <td align="center" valign="middle"  ><strong>XL</strong></td>
  <td align="center" valign="middle" ><strong>XXL</strong></td>
 </tr>
 <tr  class="content">
  <td >chest</td>
  <td align="center" valign="middle" >96</td>
  <td align="center" valign="middle" >100</td>
  <td align="center" valign="middle" >104</td>
  <td align="center" valign="middle">108</td>
  <td align="center" valign="middle">112</td>
 </tr>
 <tr  class="content">
  <td >waist</td>
  <td align="center" valign="middle" >68</td>
  <td align="center" valign="middle" >72</td>
  <td align="center" valign="middle" >76</td>
  <td align="center" valign="middle" >80</td>
  <td align="center" valign="middle" >84</td>
 </tr>
 <tr  class="content">
  <td >Hip</td>
  <td align="center" valign="middle">92</td>
  <td align="center" valign="middle">96</td>
  <td align="center" valign="middle">100</td>
  <td align="center" valign="middle" >104</td>
  <td align="center" valign="middle" >108</td>
 </tr>
 <tr  class="content">
   <td >inseam
     Length</td>
   <td align="center" valign="middle" >96</td>
   <td align="center" valign="middle" >98</td>
   <td align="center" valign="middle" >100</td>
   <td align="center" valign="middle" >102</td>
   <td align="center" valign="middle" >104</td>
 </tr>
 <tr  class="content">
   <td rowspan=2 ><strong>Measurement in inch</strong></td>
   <td colspan=5 align="center" valign="middle"><strong>Size</strong></td>
 </tr>
 <tr  class="content">
  <td align="center" valign="middle" ><strong>S</strong></td>
  <td align="center" valign="middle" ><strong>M</strong></td>
  <td align="center" valign="middle" ><strong>L</strong></td>
  <td align="center" valign="middle" ><strong>XL</strong></td>
  <td align="center" valign="middle" ><strong>XXL</strong></td>
 </tr>
 <tr  class="content">
  <td >chest</td>
  <td align="center" valign="middle" >38</td>
  <td align="center" valign="middle" >39</td>
  <td align="center" valign="middle" >41</td>
  <td align="center" valign="middle" >42.5</td>
  <td align="center" valign="middle" >44</td>
 </tr>
 <tr  class="content">
  <td >waist</td>
  <td align="center" valign="middle" >27</td>
  <td align="center" valign="middle" >28</td>
  <td align="center" valign="middle" >30</td>
  <td align="center" valign="middle" >31.5</td>
  <td align="center" valign="middle" >33</td>
 </tr>
 <tr  class="content">
  <td >Hip</td>
  <td align="center" valign="middle">36</td>
  <td align="center" valign="middle" >38</td>
  <td align="center" valign="middle" >39</td>
  <td align="center" valign="middle" >41</td>
  <td align="center" valign="middle" >42.5</td>
 </tr>
 <tr  class="content" >
  <td >inseam
  Length</td>
  <td align="center" valign="middle" >38</td>
  <td align="center" valign="middle" >38.5</td>
  <td align="center" valign="middle" >39</td>
  <td align="center" valign="middle" >40</td>
  <td align="center" valign="middle" >41</td>
 </tr>
 <tr  >
   <td ></td>
   <td ></td>
   <td ></td>
   <td ></td>
   <td ></td>
   <td ></td>
 </tr>
</table></td>
  </tr>
  <?php } else if($cat=="W") { ?>
  <tr>
    <td><table  border="0" cellpadding="5" cellspacing="1"  width="500">
      <tr  class="content">
        <td height="30" colspan="6" bgcolor="#41c1cd"  class="pro-descrip">Women's Size Chart</td>
      </tr>
      <tr  class="content">
        <td rowspan="2"  ><strong>Measurement in cm</strong></td>
        <td colspan="5" align="center" valign="middle"  ><strong>Size</strong></td>
      </tr>
      <tr  class="content">
        <td align="center" valign="middle"  ><strong>S</strong></td>
        <td align="center" valign="middle"  ><strong>M</strong></td>
        <td align="center" valign="middle" ><strong>L</strong></td>
        <td align="center" valign="middle"  ><strong>XL</strong></td>
        <td align="center" valign="middle" ><strong>XXL</strong></td>
      </tr>
      <tr  class="content">
        <td >chest</td>
        <td align="center" valign="middle" >80</td>
        <td align="center" valign="middle" >84</td>
        <td align="center" valign="middle" >92</td>
        <td align="center" valign="middle">96</td>
        <td align="center" valign="middle">100</td>
      </tr>
      <tr  class="content" >
        <td >waist</td>
        <td align="center" valign="middle" >68</td>
        <td align="center" valign="middle" >72</td>
        <td align="center" valign="middle" >76</td>
        <td align="center" valign="middle" >80</td>
        <td align="center" valign="middle" >84</td>
      </tr>
      <tr  class="content">
        <td  >Hip</td>
        <td align="center" valign="middle">82</td>
        <td align="center" valign="middle">86</td>
        <td align="center" valign="middle">90</td>
        <td align="center" valign="middle" >94</td>
        <td align="center" valign="middle" >98</td>
      </tr>
      <tr  class="content">
        <td >inseam
          Length</td>
        <td align="center" valign="middle" >60</td>
        <td align="center" valign="middle" >62</td>
        <td align="center" valign="middle" >64</td>
        <td align="center" valign="middle" >66</td>
        <td align="center" valign="middle" >68</td>
      </tr>
      <tr  class="content">
        <td rowspan="2"><strong>Measurement in inch</strong></td>
        <td colspan="5" align="center" valign="middle"><strong>Size</strong></td>
      </tr>
      <tr  class="content">
        <td align="center" valign="middle" ><strong>S</strong></td>
        <td align="center" valign="middle" ><strong>M</strong></td>
        <td align="center" valign="middle" ><strong>L</strong></td>
        <td align="center" valign="middle" ><strong>XL</strong></td>
        <td align="center" valign="middle" ><strong>XXL</strong></td>
      </tr>
      <tr  class="content">
        <td >chest</td>
        <td align="center" valign="middle" >31.5</td>
        <td align="center" valign="middle" >33</td>
        <td align="center" valign="middle" >36</td>
        <td align="center" valign="middle" >38</td>
        <td align="center" valign="middle" >39</td>
      </tr>
      <tr  class="content">
        <td >waist</td>
        <td align="center" valign="middle" >26.5</td>
        <td align="center" valign="middle" >28</td>
        <td align="center" valign="middle" >30</td>
        <td align="center" valign="middle" >31.5</td>
        <td align="center" valign="middle" >33</td>
      </tr>
      <tr  class="content">
        <td>Hip</td>
        <td align="center" valign="middle" >32</td>
        <td align="center" valign="middle" >34</td>
        <td align="center" valign="middle" >35.5</td>
        <td align="center" valign="middle" >37</td>
        <td align="center" valign="middle" >38.5</td>
      </tr>
      <tr  class="content">
        <td >inseam
          Length</td>
        <td align="center" valign="middle" >23.5</td>
        <td align="center" valign="middle" >24.5</td>
        <td align="center" valign="middle" >25</td>
        <td align="center" valign="middle" >26</td>
        <td align="center" valign="middle" >27</td>
      </tr>
      <tr  >
        <td ></td>
        <td ></td>
        <td ></td>
        <td ></td>
        <td ></td>
        <td ></td>
      </tr>
    </table></td>
  </tr>
  <?php } else if($cat=="B") { ?>
  <tr>
    <td><table  border="0" cellpadding="5" cellspacing="1"  width="500">
      <tr  class="content">
        <td height="30" colspan="6" bgcolor="#41c1cd"  class="pro-descrip">Babies Size Chart</td>
      </tr>
      <tr  class="content">
        <td rowspan="2"  ><strong>Measurement in cm</strong></td>
        <td colspan="5" align="center" valign="middle"  ><strong>Size</strong></td>
      </tr>
      <tr  class="content">
        <td align="center" valign="middle"  ><strong>3</strong></td>
        <td align="center" valign="middle"  ><strong>6</strong></td>
        <td align="center" valign="middle" ><strong>12</strong></td>
        <td align="center" valign="middle"  ><strong>24</strong></td>
      </tr>
      <tr  class="content">
        <td >Chest width </td>
        <td align="center" valign="middle" >25</td>
        <td align="center" valign="middle" >27</td>
        <td align="center" valign="middle" >29</td>
        <td align="center" valign="middle">31</td>
      </tr>
      <tr  class="content" >
        <td >Waist width Curved </td>
        <td align="center" valign="middle" >33</td>
        <td align="center" valign="middle" >35</td>
        <td align="center" valign="middle" >37</td>
        <td align="center" valign="middle" >39</td>
      </tr>
      <tr  class="content">
        <td  >Length Hsp </td>
        <td align="center" valign="middle">36</td>
        <td align="center" valign="middle">38</td>
        <td align="center" valign="middle">40</td>
        <td align="center" valign="middle" >42</td>
      </tr>
      <tr  class="content">
        <td >Shoulder</td>
        <td align="center" valign="middle" >19</td>
        <td align="center" valign="middle" >21</td>
        <td align="center" valign="middle" >23</td>
        <td align="center" valign="middle" >25</td>
      </tr>
      <tr  class="content">
        <td >A/H Straight</td>
        <td align="center" valign="middle" >10</td>
        <td align="center" valign="middle" >11</td>
        <td align="center" valign="middle" >12</td>
        <td align="center" valign="middle" >13</td>
      </tr>
      <tr  class="content">
        <td >Collar Length</td>
        <td align="center" valign="middle" >30</td>
        <td align="center" valign="middle" >32</td>
        <td align="center" valign="middle" >32</td>
        <td align="center" valign="middle" >32</td>
      </tr>
      <tr  class="content">
        <td >Collar Height Cb</td>
        <td align="center" valign="middle" >9</td>
        <td align="center" valign="middle" >10</td>
        <td align="center" valign="middle" >10</td>
        <td align="center" valign="middle" >10</td>
      </tr>
      <tr  class="content">
        <td >Bottom Hem Height</td>
        <td align="center" valign="middle" >1.5</td>
        <td align="center" valign="middle" >1.5</td>
        <td align="center" valign="middle" >1.5</td>
        <td align="center" valign="middle" >1.5</td>
      </tr>
      <tr  class="content">
        <td >Bottom Cut Height</td>
        <td align="center" valign="middle" >12</td>
        <td align="center" valign="middle" >13</td>
        <td align="center" valign="middle" >13</td>
        <td align="center" valign="middle" >13</td>
      </tr>
      <tr  class="content">
        <td rowspan="2"><strong>Measurement in inch</strong></td>
        <td colspan="5" align="center" valign="middle"><strong>Size</strong></td>
      </tr>
      <tr  class="content">
        <td align="center" valign="middle" ><strong>3</strong></td>
        <td align="center" valign="middle" ><strong>6</strong></td>
        <td align="center" valign="middle" ><strong>12</strong></td>
        <td align="center" valign="middle" ><strong>24</strong></td>
      </tr>
      <tr  class="content">
        <td >W/B Width</td>
        <td align="center" valign="middle" >1</td>
        <td align="center" valign="middle" >1</td>
        <td align="center" valign="middle" >1</td>
        <td align="center" valign="middle" >1</td>
      </tr>
      <tr  class="content">
        <td >Waist Width Top</td>
        <td align="center" valign="middle" >13</td>
        <td align="center" valign="middle" >15</td>
        <td align="center" valign="middle" >17</td>
        <td align="center" valign="middle" >19</td>
      </tr>
      <tr  class="content">
        <td>Leg Open</td>
        <td align="center" valign="middle" >11</td>
        <td align="center" valign="middle" >12</td>
        <td align="center" valign="middle" >13</td>
        <td align="center" valign="middle" >14</td>
      </tr>
      <tr  class="content">
        <td >Height CF</td>
        <td align="center" valign="middle" >20.5</td>
        <td align="center" valign="middle" >22</td>
        <td align="center" valign="middle" >23.5</td>
        <td align="center" valign="middle" >25</td>
      </tr>
      <tr  class="content">
        <td >Height CF</td>
        <td align="center" valign="middle" >22.5</td>
        <td align="center" valign="middle" >24</td>
        <td align="center" valign="middle" >25.5</td>
        <td align="center" valign="middle" >27</td>
      </tr>
      <tr  class="content">
        <td >Pouch Width -10</td>
        <td align="center" valign="middle" >10</td>
        <td align="center" valign="middle" >10</td>
        <td align="center" valign="middle" >10</td>
        <td align="center" valign="middle" >10</td>
      </tr>
      <tr  >
        <td ></td>
        <td ></td>
        <td ></td>
        <td ></td>
        <td ></td>
        
      </tr>
    </table></td>
  </tr>
  <?php } else if($cat=="K") { ?>
  <tr>
    <td><table  border="0" cellpadding="5" cellspacing="1"  width="500">
      <tr height="25"  class="content">
        <td height="30" colspan="6" bgcolor="#41c1cd"  class="pro-descrip">Kids Measurements</td>
      </tr>
      <tr  class="content">
        <td rowspan="2"  ><strong>Measurement in cm</strong></td>
        <td colspan="5" align="center" valign="middle"  ><strong>Size</strong></td>
      </tr>
      <tr  class="content">
        <td align="center" valign="middle"  ><strong>4</strong></td>
        <td align="center" valign="middle"  ><strong>6</strong></td>
        <td align="center" valign="middle" ><strong>8</strong></td>
        <td align="center" valign="middle"  ><strong>10</strong></td>
        <td align="center" valign="middle" ><strong>12</strong></td>
      </tr>
      <tr  class="content">
        <td >chest</td>
        <td align="center" valign="middle" >64</td>
        <td align="center" valign="middle" >70</td>
        <td align="center" valign="middle" >74</td>
        <td align="center" valign="middle">78</td>
        <td align="center" valign="middle">84</td>
      </tr>
      <tr  class="content">
        <td >waist</td>
        <td align="center" valign="middle" >&nbsp;</td>
        <td align="center" valign="middle" >60</td>
        <td align="center" valign="middle" >64</td>
        <td align="center" valign="middle" >68</td>
        <td align="center" valign="middle" >&nbsp;</td>
      </tr>
      <tr  class="content">
        <td>Hip</td>
        <td align="center" valign="middle">&nbsp;</td>
        <td align="center" valign="middle">80</td>
        <td align="center" valign="middle">84</td>
        <td align="center" valign="middle" >88</td>
        <td align="center" valign="middle" >&nbsp;</td>
      </tr>
      <tr  class="content">
        <td >Side seam
          Length</td>
        <td align="center" valign="middle" >&nbsp;</td>
        <td align="center" valign="middle" >74</td>
        <td align="center" valign="middle" >76</td>
        <td align="center" valign="middle" >78</td>
        <td align="center" valign="middle" >&nbsp;</td>
      </tr>
      <tr  class="content">
        <td rowspan="2"><strong>Measurement in inch</strong></td>
        <td colspan="5" align="center" valign="middle"><strong>Size</strong></td>
      </tr>
      <tr  class="content">
        <td align="center" valign="middle" ><strong>4</strong></td>
        <td align="center" valign="middle" ><strong>6</strong></td>
        <td align="center" valign="middle" ><strong>8</strong></td>
        <td align="center" valign="middle" ><strong>10</strong></td>
        <td align="center" valign="middle" ><strong>12</strong></td>
      </tr>
      <tr  class="content">
        <td >chest</td>
        <td align="center" valign="middle" >25</td>
        <td align="center" valign="middle" >27.5</td>
        <td align="center" valign="middle" >29</td>
        <td align="center" valign="middle" >31</td>
        <td align="center" valign="middle" >33</td>
      </tr>
      <tr  class="content">
        <td >waist</td>
        <td align="center" valign="middle" >&nbsp;</td>
        <td align="center" valign="middle" >23.5</td>
        <td align="center" valign="middle" >25</td>
        <td align="center" valign="middle" >26.5</td>
        <td align="center" valign="middle" >&nbsp;</td>
      </tr>
      <tr  class="content" >
        <td >Hip</td>
        <td align="center" valign="middle" >&nbsp;</td>
        <td align="center" valign="middle" >31.5</td>
        <td align="center" valign="middle" >33</td>
        <td align="center" valign="middle" >34.5</td>
        <td align="center" valign="middle" >&nbsp;</td>
      </tr>
      <tr  class="content">
        <td >Side seam
          Length</td>
        <td align="center" valign="middle" >&nbsp;</td>
        <td align="center" valign="middle" >29</td>
        <td align="center" valign="middle" >30</td>
        <td align="center" valign="middle" >31</td>
        <td align="center" valign="middle" >&nbsp;</td>
      </tr>
      <tr  >
        <td ></td>
        <td ></td>
        <td ></td>
        <td ></td>
        <td ></td>
        <td ></td>
      </tr>
    </table></td>
  </tr>
  <?php } ?>
</table>
</body>
</html>
