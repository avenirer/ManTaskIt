<script>
$('#members_options').textext({
plugins : 'autocomplete  filter tags ajax',
ajax : {
url : '<?php echo site_url('members/suggest_members/?');?>',
dataType : 'json',
cacheResults : true
}
})
</script>