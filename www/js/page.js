/**
 * 翻页组件
 * options {}
 * page: 翻页对象
 * pageNo, 当前页
 * pageSize, 当前页要显示的数量
 * pageCount, 总页数
 * pageTotal, 总数量
 * callback, 操作的动作
 * */
function Page(options){
	this.page = $(options.page);
	this.pageNo = 1;
	this.pageSize = 0;
	this.pageCount = 0;
	this.pageTotal = 0;
	this.callback = options.callback;
	this.init();
}

Page.prototype = {
	constructor: Page,
	
	init: function(){
		var self = this,
			page = this.page;
		$('a',page).live('click',function(e){
			var t = $(this),
				className = t.attr('class').replace('icons ','');
			switch(className){
			case 'icon-page-next':
				self.pageNo++;
				break;
			case 'icon-page-prev':
				self.pageNo--;
				break;
			case 'icon-page-first':
				self.pageNo = 1;
				break;
			case 'icon-page-last':
				self.pageNo = self.pageCount;
				break;
			}
			self.jump();
			return false;
		});
		
		$(':text',page).live('keyup',function(e){
			var t = $(this),
				value = t.val();
			if(/^[0-9]+$/.test(value)){
				self.pageNo = value;
			}else{
				t.val('');
			}
			
			if(e.keyCode == 13){
				self.jump();
			}
		});
	},
	
	/*
	 * 更新翻页状态
	 * */
	update: function(options){
		for(var i in options){
			this[i] = options[i];
		}
		var html = '', pageCount = this.pageCount;
		if(this.pageTotal == 0 || pageCount == 1){
			html = '<i class="icons icon-page-first"></i>'
				+'<i class="icons icon-page-prev"></i>'
				+'<span class="page-textarea">'
				+'第<input type="text" class="text" value="1" title="按回车键跳转" /> /<span class="page-count">1</span>页'
				+'</span>'
				+'<i class="icons icon-page-next"></i>'
				+'<i class="icons icon-page-last"></i>';
		}else if(this.pageNo == 1){
			html = '<i class="icons icon-page-first"></i>'
				+'<i class="icons icon-page-prev"></i>'
				+'<span class="page-textarea">'
				+'第<input type="text" class="text" value="1" title="按回车键跳转" /> /<span class="page-count">'+ pageCount +'</span>页'
				+'</span>'
				+'<a href="#" class="icons icon-page-next" title="下一页"></a>'
				+'<a href="#" class="icons icon-page-last" title="最后一页"></a>';
		}else if(this.pageNo == pageCount){
			html = '<a href="#" class="icons icon-page-first" title="第一页"></a>'
				+'<a href="#" class="icons icon-page-prev" title="上一页"></a>'
				+'<span class="page-textarea">'
				+'第<input type="text" class="text" value="'+ pageCount +'" title="按回车键跳转" /> /<span class="page-count">'+ pageCount +'</span>页'
				+'</span>'
				+'<i class="icons icon-page-next"></i>'
				+'<i class="icons icon-page-last"></i>';
		}else{
			html = '<a href="#" class="icons icon-page-first" title="第一页"></a>'
				+'<a href="#" class="icons icon-page-prev" title="上一页"></a>'
				+'<span class="page-textarea">'
				+'第<input type="text" class="text" value="'+ this.pageNo +'" title="按回车键跳转" /> /<span class="page-count">'+ pageCount +'</span>页'
				+'</span>'
				+'<a href="#" class="icons icon-page-next" title="下一页"></a>'
				+'<a href="#" class="icons icon-page-last" title="最后一页"></a>';
		}
		this.page.html(html);
	},
	
	//根据当前页来跳转页面
	jump: function(){
		if(this.pageNo > this.pageCount) this.pageNo = this.pageCount;
		else if(this.pageNo < 1) this.pageNo = 1;
		
		this.callback({ pageNo: this.pageNo});
	},
	
	getCurrentPageNo: function(){
		return this.pageNo;
	}
};
