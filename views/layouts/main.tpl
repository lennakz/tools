{use class="yii\helpers\Html"}

{$this->beginPage()}
<!DOCTYPE html>
<html lang="{$app->language}">
	<head>
		<meta charset="{$app->charset}">
		<meta http-equiv="X-UA-Compatible" content="IE=edge">
		<meta name="viewport" content="width=device-width, initial-scale=1">
		{Html::csrfMetaTags()}
		<title>{Html::encode($this->title)}</title>
		{$this->head()}
	</head>
	<body class="{$this->bodyClass}">
		{$this->beginBody()}
		
		<div class="wrapper">
			
			{$content}
			
		</div>

		{*<div id="loading-gif">
			{Html::img('@web/images/loading.gif')}
		</div>*}
		
		{$this->endBody()}
	</body>
</html>
{$this->endPage()}
