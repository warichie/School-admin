<?
/**[N]**
 * JIBAS Education Community
 * Jaringan Informasi Bersama Antar Sekolah
 * 
 * @version: 3.0 (January 09, 2013)
 * @notes: JIBAS Education Community will be managed by Yayasan Indonesia Membaca (http://www.indonesiamembaca.net)
 * 
 * Copyright (C) 2009 Yayasan Indonesia Membaca (http://www.indonesiamembaca.net)
 * 
 * This program is free software: you can redistribute it and/or modify
 * it under the terms of the GNU General Public License as published by
 * the Free Software Foundation, either version 3 of the License, or
 * (at your option) any later version.
 * 
 * This program is distributed in the hope that it will be useful,
 * but WITHOUT ANY WARRANTY; without even the implied warranty of
 * MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
 * GNU General Public License for more details.
 * 
 * You should have received a copy of the GNU General Public License
 **[N]**/ ?>
<?
class FormatPresensi{
	function Main(){
		$sql = "SELECT * FROM format WHERE tipe=0";
		$res = QueryDb($sql);
		$row = @mysql_fetch_array($res);
		?>
		<link href="../style/style.css" rel="stylesheet" type="text/css" />
		<table border="0" cellspacing="0" cellpadding="0" align="center">
          <tr>
            <td width="293">
                <div id="TabbedPanelsA" class="TabbedPanels">
                  <ul class="TabbedPanelsTabGroup">
                    <li class="TabbedPanelsTab" tabindex="0"><strong>Message Format</strong></li>
                  </ul>
                  <div class="TabbedPanelsContentGroup">
                    <div class="TabbedPanelsContent" style="padding-top:5px; overflow:inherit">
                        <table border="0" cellspacing="0" cellpadding="0"  align="center">
                          <tr>
                            <td class="td" style="padding:10px">
                            <textarea id="Format" cols="40" rows="10" class="AreaTxt" disabled="disabled" ><?=$row['format']?></textarea>
                            </td>
                          </tr>
                          <tr>
                            <td class="td" align="center">
                            <?php
							if ($_SESSION['tingkat']!='2'){
							?>
							<div class="BtnSilver" align="center" id="BtnEdit" onclick="Change()">Edit</div>
                            <div class="BtnSilver" align="center" id="BtnSave" style="display:none" onclick="Simpan()">Save</div>
                            <?php 
							}
							?>
							</td>
                          </tr>
                        </table>
                    </div>
                  </div>
                </div>
            </td>
            <td width="358" valign="top">
                <div id="TabbedPanelsA" class="TabbedPanels">
                  <ul class="TabbedPanelsTabGroup">
                    <li class="TabbedPanelsTab" tabindex="0"><strong>Info.</strong></li>
                  </ul>
                  <div class="TabbedPanelsContentGroup">
                    <div class="TabbedPanelsContent" style="padding-top:5px; overflow:inherit">
                        <table width="100%" border="0" cellspacing="0" cellpadding="0">
                          <tr>
                            <td class="td">[SISWA]</td>
                            <td class="td">Student Name</td>
                          </tr>
                          <tr>
                            <td class="td">[TANGGAL1]</td>
                            <td class="td">Start Date</td>
                          </tr>
                          <tr>
                            <td class="td">[BULAN1]</td>
                            <td class="td">Start Month</td>
                          </tr>
                          <tr>
                            <td class="td">[TANGGAL2]</td>
                            <td class="td">End Date</td>
                          </tr>
                          <tr>
                            <td class="td">[BULAN2]</td>
                            <td class="td">End Month</td>
                          </tr>
                          <tr>
                            <td class="td">[PENGIRIM]</td>
                            <td class="td">Sender</td>
                          </tr>
                          <tr>
                            <td class="td">[HADIR]</td>
                            <td class="td">Student Attendance Data</td>
                          </tr>
                          <tr>
                            <td class="td">[ABSEN]</td>
                            <td class="td">Student Absent Data</td>
                          </tr>
                      </table>
                    </div>
                  </div>
                </div>
             </td> 
            </tr>
            <tr><td colspan="2">&nbsp;</td></tr>
            <tr>
            <td colspan="2">
        		<b>ATTENDANCE FORMAT MESSAGE INFORMATION</b><br /><br/>
                <span class="Ket">    
                    if an information was sent within a format below: <br />
                    <b>Attendance information of [SISWA] date [TANGGAL1]/[BULAN1] to [TANGGAL2]/[BULAN2].<br />
                    Attendance [HADIR]. Absent [ABSEN]. Sender [PENGIRIM]</b><br /><br />
                    the student will receive an information: <br />
                    <b>Attendance information of Jafar Ashiddiq date 1/2 to 28/2. Attendance 22. Absent 2. Sender Bag.Akademik</b>
                </span>
            </td>
          </tr>
        </table>
		<?
	}
}
?>