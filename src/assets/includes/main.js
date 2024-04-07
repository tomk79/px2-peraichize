const $ = require('jquery');
const $script = $('script').last();
const params = {
	__dirname: $script.attr('src').replace(/[^\/]+$/, ''),
};

module.exports = function(){
	const self = this;
}
