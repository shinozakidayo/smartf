<p>ようこそ！<?php echo h($userinfo['username']);?> <?php echo h($userinfo['id']); ?>さん</p>
<h2>ここはIndexページです</h2>
<ul>
<li><?php echo $this->Html->link('ログアウト','logout',array(),'ログアウトしてもいいですか？');?></li>
<li>
<?php
echo $this->Html->link(
'新規ユーザ作成',
array(
'controller' => 'Accounts',
'action' => 'add')
);
?>
</li>
<li>
<?php
echo $this->Html->link(
'アカウント管理',
array(
'controller' => 'adminYui')
);
?>
</li>


<li>

<?php
echo "<br>" . $aname . "<br>";
echo $cname . "<br>";
echo $roledata . "<br>";
?>
</li>
</ul>

