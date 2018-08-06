{$main = $this->beginContent('@layouts/main.tpl')}

	{$this->render('/partials/header')}
			
	{$this->render('/partials/left-sidebar')}

	<div class="content-wrapper">
		<section class="content-header">
			<h1>{$this->pageHeader|escape}
				<small>{$this->pageSubheader|escape}</small>
			</h1>
			<ol class="breadcrumb">
				<li><a href="#"><i class="fa fa-dashboard"></i> Level</a></li>
				<li class="active">Here</li>
			</ol>
		</section>

		<section class="content container-fluid">

			{$content}

		</section>				
	</div>

	{$this->render('/partials/footer')}

	{$this->render('/partials/right-sidebar')}

{$this->endContent()}