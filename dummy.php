<html>
<form id="myform" action="autoredirect.php">
<input type="submit" name="dummy">
</html>
<script>
window.onload=function(){
document.myform.dummy.click();
}
</script>