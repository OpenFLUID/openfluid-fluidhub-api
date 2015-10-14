<?php
#
#   This file is part of OpenFLUID software
#   Copyright(c) 2007, INRA - Montpellier SupAgro
#
#
#  == GNU General Public License Usage ==
#
#   OpenFLUID is free software: you can redistribute it and/or modify
#   it under the terms of the GNU General Public License as published by
#   the Free Software Foundation, either version 3 of the License, or
#   (at your option) any later version.
#
#   OpenFLUID is distributed in the hope that it will be useful,
#   but WITHOUT ANY WARRANTY; without even the implied warranty of
#   MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
#   GNU General Public License for more details.
#
#   You should have received a copy of the GNU General Public License
#   along with OpenFLUID. If not, see <http://www.gnu.org/licenses/>.
#
#
#  == Other Usage ==
#
#   Other Usage means a use of OpenFLUID that is inconsistent with the GPL
#   license, and requires a written agreement between You and INRA.
#   Licensees for Other Usage of OpenFLUID may use this file in accordance
#   with the terms contained in the written agreement between You and INRA.
#


error_reporting(0);


// =====================================================================
// =====================================================================


$WaresRepos = array (
  "simulators" => array(
    "examples.sim.A" => array(
      "shortdesc" => "This is examples.sim.A...",
      "git-url" => "https://host.domain.org/foo-wareshub/git/simulators/examples.sim.A",
      "git-branches" => array("openfluid-2.0","openfluid-2.1"),
      "issues-counts" => array("bugs" => 1, "features" => 0, "reviews" => 2),
      "users-ro" => array("*"),
      "users-rw" => array("user1","user2","user3")
    ),
    "examples.sim.B" => array(
      "shortdesc" => "This is examples.sim.B...",
      "git-url" => "https://host.domain.org/foo-wareshub/git/simulators/examples.sim.B",
      "git-branches" => array("openfluid-1.7","openfluid-2.0","openfluid-2.1"),
      "issues-counts" => array("bugs" => 1, "features" => 0, "reviews" => 2),
      "users-ro" => array("*"),
      "users-rw" => array("user1")
    ),
    "examples.sim.C" => array(
      "shortdesc" => "This is examples.sim.C...",
      "git-url" => "https://host.domain.org/foo-wareshub/git/simulators/examples.sim.C",
      "git-branches" => array("openfluid-2.0","openfluid-2.1","openfluid-2.2-preview"),
      "issues-counts" => array("bugs" => 1, "features" => 0, "reviews" => 2),
      "users-ro" => array("*"),
      "users-rw" => array("user2","user3")
    ),
    "examples.sim.D" => array(
      "shortdesc" => "This is examples.sim.D...",
      "git-url" => "https://host.domain.org/foo-wareshub/git/simulators/examples.sim.D",
      "git-branches" => array("master"),
      "issues-counts" => array("bugs" => 1, "features" => 1, "reviews" => 1),
      "users-ro" => array("*"),
      "users-rw" => array("user1")
    )
  ),
  "observers" => array(
    "examples.obs.J" => array(
      "shortdesc" => "This is examples.obs.J...",
      "git-url" => "https://host.domain.org/foo-wareshub/git/observers/examples.obs.J",
      "git-branches" => array("openfluid-2.0","openfluid-2.1"),
      "issues-counts" => array("bugs" => 1, "features" => 0, "reviews" => 2),
      "users-ro" => array("user1"),
      "users-rw" => array("user2")
    ),
    "examples.obs.K" => array(
      "shortdesc" => "This is examples.obs.K...",
      "git-url" => "https://host.domain.org/foo-wareshub/git/observers/examples.obs.K",
      "git-branches" => array(""),
      "issues-counts" => array("bugs" => 0, "features" => 0, "reviews" => 0),
      "users-ro" => array("*"),
      "users-rw" => array("user1")
    )
  ),
  "builderexts" => array(
    "examples.bext.X" => array(
      "shortdesc" => "This is examples.bext.X...",
      "git-url" => "https://host.domain.org/foo-wareshub/git/builderexts/examples.bext.X",
      "git-branches" => array("openfluid-2.0","openfluid-2.1"),
      "issues-counts" => array("bugs" => 1, "features" => 0, "reviews" => 2),
      "users-ro" => array(),
      "users-rw" => array("*")
    )
  )
);


// =====================================================================


function getWaresInfos($WareType,$Username)
{
  global $WaresRepos;

  $GitUser = $Username;

  if ($GitUser != "")
    $GitUser .= "@";

  $JSONContent = "{\n";

  $IsFirstWare = true;
  foreach ($WaresRepos[$WareType] as $WareID => $WareInfos)
  {
    if ($IsFirstWare)
      $IsFirstWare = false;
    else
      $JSONContent .= ",\n";

    $GitURL = str_replace("https://","https://${GitUser}",$WareInfos["git-url"]);

    $JSONContent .= "  \"{$WareID}\": {\n";
    $JSONContent .= "    \"shortdesc\": \"{$WareInfos["shortdesc"]}\",\n";
    $JSONContent .= "    \"git-url\": \"{$GitURL}\",\n";

    $Branches = implode("\",\"",$WareInfos["git-branches"]);
    if ($Branches != "")
      $Branches = "\"".$Branches."\"";

    $JSONContent .= "    \"git-branches\": [{$Branches}],\n";

    $JSONContent .= "    \"issues-counts\": {\n";
    $JSONContent .= "      \"bugs\": {$WareInfos["issues-counts"]["bugs"]},\n";
    $JSONContent .= "      \"features\": {$WareInfos["issues-counts"]["features"]},\n";
    $JSONContent .= "      \"reviewss\": {$WareInfos["issues-counts"]["reviews"]}\n";
    $JSONContent .= "    },\n";    

    $UserList = implode("\",\"",$WareInfos["users-ro"]);
    if ($UserList != "")
      $UserList = "\"".$UserList."\"";

    $JSONContent .= "    \"users-ro\": [{$UserList}],\n";

    $UserList = implode("\",\"",$WareInfos["users-rw"]);
    if ($UserList != "")
      $UserList = "\"".$UserList."\"";

    $JSONContent .= "    \"users-rw\": [{$UserList}]\n";

    $JSONContent .= "  }";
  }

  $JSONContent .= "\n}";

  return $JSONContent;
}


// =====================================================================


function isWareType($WareType)
{
  return in_array($WareType,array("simulators","observers","builderexts"));
}


// =====================================================================
// =====================================================================


require("Slim/Slim.php");


\Slim\Slim::registerAutoloader();

$app = new \Slim\Slim();


// =====================================================================
// =====================================================================


$app->get('/',function () use($app)
{
  $app->response->headers->set('Content-Type', 'application/json ; charset=UTF8');
  echo "{\n";
  echo "  \"nature\" : \"OpenFLUID FluidHub\",\n";
  echo "  \"api-version\" : \"1.0.20150107\",\n";
  echo "  \"capabilities\" : [\"news\",\"wareshub\"],\n";
  echo "  \"status\" : \"testing\",\n";
  echo "  \"name\" : \"fluidhub for testing\"\n";
  echo "}";
});


// =====================================================================
// =====================================================================


$app->get('/news',function () use($app)
{
  $lang = $app->request()->params('lang');

  if (empty($lang))
    $lang = "en";

  $RSSContent = "";

  $app->response->headers->set('Content-Type', 'application/rss+xml; charset=UTF8');

  if ($lang == "en")
  {
    $RSSContent = <<<EOD
<rss version="2.0">
  <channel>
    <title></title>
    <description></description>
    <link></link>
    <copyright>Copyrigh INRA-SupAgro</copyright>

    <item>
      <title>Item 1</title>
      <description>This is Item 1</description>
      <link>http://item1.org</link>
      <pubDate>2105-09-30</pubDate>
      <category>doc</category>
    </item>

    <item>
      <title>Item 2</title>
      <description>This is Item 2</description>
      <link>http://item2.org</link>
      <pubDate>2105-09-26</pubDate>
      <category>software</category>
    </item>

    <item>
      <title>Item 3</title>
      <description>This is Item 3</description>
      <link>http://item3.org</link>
      <pubDate>2105-09-12</pubDate>
      <category>training</category>
    </item>

  </channel>
</rss>
EOD;
  }
  else if ($lang == "fr")
  {
$RSSContent = <<<EOD
<rss version="2.0">
  <channel>
    <title></title>
    <description></description>
    <link></link>
    <copyright>Droits réservés INRA-SupAgro</copyright>

    <item>
      <title>Article 1</title>
      <description>C'est l'élément 1</description>
      <link>http://item1.org</link>
      <pubDate>2105-09-30</pubDate>
      <category>doc</category>
    </item>

  </channel>
</rss>
EOD;
  }

  echo $RSSContent;
});


// =====================================================================
// =====================================================================


$app->get('/wares',function () use($app)
{
  global $WaresRepos;

  $app->response->headers->set('Content-Type', 'application/json ; charset=UTF8');

  $JSONContent = "{\n";

  $IsFirstType = true;
  foreach ($WaresRepos as $WareType => $WaresSet)
  {
    if ($IsFirstType)
      $IsFirstType = false;
    else
      $JSONContent .= ",\n";

    $JSONContent .= "  \"{$WareType}\" : [\n";

    $IsFirstWare = true;
    foreach ($WaresSet as $WareID => $WareInfo)
    {
      if ($IsFirstWare)
        $IsFirstWare = false;
      else
        $JSONContent .= ",\n";

      $JSONContent .= "    \"".$WareID."\"";
    }

    $JSONContent .= "\n  ]";
  }

  $JSONContent .= "\n}";

  echo $JSONContent;

});


// =====================================================================
// =====================================================================


$app->get('/wares/:waretype',function ($waretype) use($app)
{
  $username = $app->request()->params('username');

  if (isWareType($waretype))
  {
    $app->response->headers->set('Content-Type', 'application/json ; charset=UTF8');
    echo getWaresInfos($waretype,$username);
  }
  else
    $app->response->setStatus(401);
});


// =====================================================================
// =====================================================================


$app->put('/wares/:waretype/:wareid',function ($waretype,$wareid) use($app)
{
  $app->response->setStatus(501);
});


// =====================================================================
// =====================================================================


$app->patch('/wares/:waretype/:wareid',function ($waretype,$wareid) use($app)
{
  $app->response->setStatus(501);
});


// =====================================================================
// =====================================================================


$app->delete('/wares/:waretype/:wareid',function ($waretype,$wareid) use($app)
{
  $app->response->setStatus(501);
});


// =====================================================================
// =====================================================================


$app->get('/wares/:waretype/:wareid/git',function ($waretype,$wareid) use($app)
{
  $app->response->setStatus(501);
});


// =====================================================================
// =====================================================================


$app->get('/wares/:waretype/:wareid/git/:branch',function ($waretype,$wareid,$branch) use($app)
{
  $app->response->setStatus(501);
});


// =====================================================================
// =====================================================================


$app->get('/wares/:waretype/:wareid/git/:branch/issues',function ($waretype,$wareid,$branch) use($app)
{
  $app->response->setStatus(501);
});


// =====================================================================
// =====================================================================


$app->get('/wares/:waretype/:wareid/git/:branch/commits',function ($waretype,$wareid,$branch) use($app)
{
  $app->response->setStatus(501);
});


// =====================================================================
// =====================================================================


// handle errors
$app->notFound(function ()
{
  header('HTTP/1.1 400 Bad Request',true,400);
});


// =====================================================================
// =====================================================================


$app->run();

?>
