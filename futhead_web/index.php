<?php
   include('session.php');
?>
<html>
<head>
	<meta charset="UTF-8">
    <title>FIFA Player Rating Database</title>
	<meta name="author" content="WebDev">
	<link rel="stylesheet" type="text/css" href="index.css" />
</head>
<body>
	<div id="welcome_form" >
      Welcome <?php echo $login_session; ?> &nbsp;|&nbsp;
      <a href = "logout.php">Sign Out</a>
	  </div>
	<div id="big_wrapper">
		<header id="top_header">
			<h1>FIFA Player Database</h1>
		</header>
 
<nav id="top_menu" >
  <ul>
	<li><a href=index.php>Home</a></li>
	<li><a href=position.php>Position</a></li>
	<li><a href=team.php>Team</a></li>
	        <div id= "search_bar" align= "right">
            <form action="search.php" method="get">
                Search by Name: <input type="text" name="search" />
                <input type="submit" name="ok" value="search" />
            </form>
        </div>
  </ul>
</nav>

        <table border="1"; width=100%>
            <tr>
                <th>ID</th>
                <th>Player Name</th>
				<th>Nation</th>
				<th>Position</th>
				<th>Team</th>
				<th>Squad Number</th>
				<th>League</th>
				<th>OVR</th>
            </tr>
<?php
require('connect_db.php');

$sql = 'SELECT * FROM player left outer join playfor ON player.id = playfor.id left outer join team ON team.teamid = playfor.teamid ORDER BY player.*';
foreach ($dbh->query($sql) as $row) 
{
echo "<tr>
<td><a href=\"playerinfo.php?id={$row['id']}\">{$row['id']}</a></td>
<td><a href=\"playerinfo.php?id={$row['id']}\">{$row['name']}</a></td>
<td><a href=\"nationinfo.php?name={$row['nation']}\">{$row['nation']}</a></td>
<td><a href=\"position.php\">{$row['position']}</a></td>
<td><a href=\"teaminfo.php?id={$row['teamid']}\">{$row['team name']}</a></td>
<td><a href=\"squadnum.php?sn={$row['squadnum']}\">{$row['squadnum']}</a></td>
<td><a href=\"leagueinfo.php?name={$row['league']}\">{$row['league']}</a></td>
<td><a href=\"ovr.php?ovr={$row['ovr']}\">{$row['ovr']}</a></td>
</tr>";
}
?>
        </table>
    </body>
</html>

