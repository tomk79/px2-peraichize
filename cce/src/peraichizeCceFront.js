window.peraichizeCceFront = function(cceAgent){
	let $elm = cceAgent.elm();

	$elm.innerHTML = `
		<p>統合ページを更新します。</p>
		<p><button type="button" class="px2-btn px2-btn--primary cont-btn-create-index">更新する</button></p>
	`;

	$elm.querySelector('button')
		.addEventListener('click', function(){
			const elm = this;
			px2style.loading();
			elm.setAttribute('disabled', true);

			cceAgent.gpi({
				'command': 'create'
			}, function(res){
				console.log('---- res:', res);
				if(res.result){
					alert('統合ページを更新しました。');
				}else{
					alert('[ERROR] 統合ページの更新に失敗しました。');
				}
				px2style.closeLoading();
				elm.removeAttribute('disabled');
			});
		});
}