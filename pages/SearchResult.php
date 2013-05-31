<div class="page-header"><h2>Search Results</h2></div>
<!--<div id="loading">Wait here while we load your recipes. This could take a while.</div>
<div id="content"> </div>

<script>
$(document).ready(function(){
    $('#content').load('modules/loadResult.php?<?php echo http_build_query($_GET,'','&');?>');
    $('#loading').hide();
    $('#content').show();
});
</script>-->

<?php
include 'modules/loadResult.php';

