window.peraichizeCceFront=function(t){var e=t.elm();e.innerHTML='\n\t\t<p>インデックスを更新します。</p>\n\t\t<p><button type="button" class="px2-btn px2-btn--primary cont-btn-create-index">インデックスを更新</button></p>\n\t',e.querySelector("button").addEventListener("click",(function(){var e=this;px2style.loading(),e.setAttribute("disabled",!0),t.gpi({command:"create"},(function(t){console.log("---- res:",t),t.result?alert("インデックスを更新しました。"):alert("[ERROR] インデックスの更新に失敗しました。"),px2style.closeLoading(),e.removeAttribute("disabled")}))}))};