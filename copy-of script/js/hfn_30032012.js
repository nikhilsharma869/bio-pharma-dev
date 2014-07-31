/*header*/
var ddn = function(b) {
  var a = this;
  a.ev = b.ev;
  a.cl = b.cl;
  a.oldcl = b.oldcl;
  a.id = b.id;
  a.idObj = $n(a.id);
  a.c='';
  $n("#iframeId").length || (a.idObj.append($n("<iframe>").attr({id:"iframeId"})), a.frameObj = $n("#iframeId"), a.frameObj.addClass("iframeBox"));
  a.child = $n(a.id+" a[rel]");
  a.b = "";
  a.brw=$n.brewser().name;
  a.child.addEvent('mouseover', function() {
	  	if(a.brw=='mozilla' && a.timer){
			clearTimeout(a.timer)
        a.b.replaceClass(a.cl, a.oldcl);
        a.c.hide();
        a.frameObj.hide()
		}
    a.b = $n(this);
    var b = a.b.position(), d = a.b.attr("rel");
    if(d) {
      a.b.replaceClass(a.oldcl, a.cl);
      a.c = $n("#" + d);
      a.frameObj || (a.frameObj = $n("#iframeId"));
      a.frameObj.css({top:b.top + a.b.height() - 1 + "px", left:b.left + "px", width:a.c.width() + "px", height:a.c.height() + "px"}).show();
      a.c.css({top:b.top + a.b.height() - 1 + "px", left:b.left + "px"}).show().addEvent("mouseover", a.divMouseover).addEvent("mouseout", a.divMouseOut)
    }
  }).addEvent("mouseout", function() {
	  if(a.b.attr("rel")){
    $n("#" + a.b.attr("rel")).hide();
    a.frameObj.hide();
    a.b.replaceClass(a.cl, a.oldcl)
	  }
  })
  a.timer='';
  a.divMouseOut=function(e) {
	if(a.brw=='mozilla'){
	  	a.timer=setTimeout(function(){
        a.b.replaceClass(a.cl, a.oldcl);
        a.c.hide();
        a.frameObj.hide()
		}, 10)
  }
  else{
        a.b.replaceClass(a.cl, a.oldcl);
        a.c.hide();
        a.frameObj.hide()
  }
   }
   a.divMouseover=function(e){
	if(a.brw=='mozilla')
	   clearTimeout(a.timer)
        a.c.show();
        a.frameObj.show();
        a.b.replaceClass(a.oldcl, a.cl)
   }
};

/*header*/

function adjustFoot(){
  if($n('#colLB').length){
	var d=$n('#colLB').position();
  var e=$n('#colRB').position();
  var g=$n('#colL');
  var h=$n('#colR');
  g.css({'top':d['top']+'px', 'left':d['left']+'px'}).show();
  h.css({'top':d['top']+'px', 'left':e['left']+'px'}).show();
  var a=g.height();var b=h.height();var f=$n('#footerAdjust');
  f.hide();
  var c=$n('body').height()-d['top'];
  var top=(a>b && a>c) ? a : ((a<b && b>c) ?	b : c);
  f.css({'top':top+d['top']+20+'px'}).show();
  }
}
var kw_arr=[];
var loc_arr=[];

$n(document).ready(function(){
  var topDD=new ddn({'cl':'selul', 'oldcl':'dropD', 'id':'#mNav', 'ev':'mouseover'});
	adjustFoot();
	var sbDDTop=new sbDD({'idBand':'srcBgTop'});
	var sbDDTop=new sbDD({'idBand':'srcBgBot'});
	$n('#footerLnk a').attr({'target':'_blank'});
	$n.footerCarousel({id:'carMove', speed:10, howmanymove:4})
  var srcTopKw=$n('#srcBgTop input').eq(2);
  var srcTopLoc=$n('#srcBgTop input').eq(3);
  var srcBotKw=$n('#srcBgBot input').eq(2);
  var srcBotLoc=$n('#srcBgBot input').eq(3);
srcTopKw.addEvent('focus', function(){srpDefaultText(srcTopKw,'Enter designation, role, skills etc.');}).addEvent('blur', function(){srpDefaultText(srcTopKw,'Enter designation, role, skills etc.');});
srcTopLoc.addEvent('focus', function(){srpDefaultText(srcTopLoc,'Enter city or state');}).addEvent('blur', function(){srpDefaultText(srcTopLoc,'Enter city or state');});
srcBotKw.addEvent('focus', function(){srpDefaultText(srcBotKw,'Enter designation, role, skills etc.');}).addEvent('blur', function(){srpDefaultText(srcBotKw,'Enter designation, role, skills etc.');});
srcBotLoc.addEvent('focus', function(){srpDefaultText(srcBotLoc,'Enter city or state');}).addEvent('blur', function(){srpDefaultText(srcBotLoc,'Enter city or state');});

	$n('#srcBgTop input').eq(2).suggester({countSugg:'15',arry:kw_arr});$n('#srcBgBot input').eq(2).suggester({countSugg:'15',arry:kw_arr});
	$n('#srcBgTop input').eq(3).suggester({countSugg:'15',arry:loc_arr});$n('#srcBgBot input').eq(3).suggester({countSugg:'15',arry:loc_arr});
 srpDefaultText(srcTopKw,'Enter designation, role, skills etc.');
  srpDefaultText(srcTopLoc,'Enter city or state');
  srpDefaultText(srcBotKw,'Enter designation, role, skills etc.');
  srpDefaultText(srcBotLoc,'Enter city or state');
  
  $n('form[name=quickbar]').eq(0).addEvent('submit',function(e){
	  	validate_qsb(e, $n(this), '#srcBgTop');
  })
  $n('form[name=quickbar]').eq(1).addEvent('submit',function(e){
	  	validate_qsb(e, $n(this), '#srcBgBot');
  })

	$n('#quesSrt').addEvent('click', function(){
		var pos=$n(this).position()
		$n('#sortHlp').show().css({'top':pos['top']+'px', 'left':pos['left']-$n('#sortHlp').width()+12+'px'});
		$n('#sortHlp a').setFocus()
	})
	$n('#sortHlp a').addEvent('blur', function(){
		$n('#sortHlp').hide();
	}).addEvent('click', function(){
		$n('#sortHlp').hide();
  })
  $n('#colL h3').addEvent('click', function(e){
                if($n(this).currObj().nodeName.toLowerCase()!='h3'){
                                var thisCur=$n(this).parent();
                }else{
                                var thisCur=$n(this);
                }
                                thisCur.toggleClass('srpP', 'srpM');
                thisCur.next().toggleClass('dspN', 'dspB')
  })
  if($n.brewser().name=='msie'){
  $n('#colL h3 i').addEvent('click', function(e){
    $n(this).parent().currObj().click();
    stpProp($n(document).ev(e));
  })
  }
  var sortByDD=new ddn({'cl':'mAct1', 'oldcl':'mAct', 'id':'#lrCol', 'ev':'mouseover'});
  toggleTuple();
})
window.onresize=function(){
//	adjustFoot();
}
var stpProp=function(ev){
                if(ev.stopPropogation)
                                ev.stopPropogation()
                                else
                                ev.cancelBubble = true;
}
var validate_qsb=function(e, obj, id){
  var srcB=obj.childrens('input');
  if(srcB.eq(2).val()=='Enter designation, role, skills etc.'){
    srcB.eq(2).val('');
}
  if(srcB.eq(3).val()=='Enter city or state'){
    srcB.eq(3).val('');
}
  var kw=srcB.eq(2).val();
  var loc=srcB.eq(3).val();
  var farea=srcB.eq(4).val();
  var exp=srcB.eq(5).val();
  var minsal=srcB.eq(6).val();
  var maxsal=srcB.eq(7).val();

  if(!($n.trim(kw)) && !($n.trim(loc)) && farea=='Select'){
    setTimeout(function(){
	  obj.childrens('button').currObj().focus();
	  srcB.eq(2).val('Enter designation, role, skills etc.').css({color:'#8d8d8d'});
	  srcB.eq(3).val('Enter city or state').css({color:'#8d8d8d'});
    }, 50)
	  srcB.eq(2).parent().addClass('errIN')
	  srcB.eq(3).parent().addClass('errIN')
	  srcB.eq(4).parent().addClass('errIN')
    $n(id+" .errorTxt").html("Please enter Keywords or Location or select Job Category to search.");
		e=$n(document).ev(e);
		if(e.preventDefault)
		e.preventDefault() 
		else 
		e.returnValue = false;

  }
  else if(loc)
  {
     var locinChar=/[^a-zA-Z,.;&\\\/\s\-()]/;
     if(locinChar.test(loc))
     {
          obj.childrens('button').currObj().focus();
          srcB.eq(3).parent().addClass('errIN')
	  if(!kw){
        setTimeout(function(){
	          srcB.eq(2).val('Enter designation, role, skills etc.').css({color:'#8d8d8d'});
        }, 50)
    }
	  $n(id+" .errorTxt").html("Please avoid entering any number/special character in location field.");
          e=$n(document).ev(e);
          if(e.preventDefault)
              e.preventDefault()
          else
              e.returnValue = false;
     }
  }
      var formname = $n(id+" form[name=quickbar]");
      var selct=srcB.eq(4).parent().next().childrens('select').currObj();
      var fareaid=selct.options[selct.selectedIndex].value;
      if(loc!="" && farea=="Select" && Loc_Map_Arr[$n.trim(loc).toLowerCase()] && !kw && exp=='Exp.' &&  minsal == 'Min' &&  maxsal == 'Max')
           formname.attr({'action':domain_cat+"jobs-in-" + Loc_Map_Arr[$n.trim(loc).toLowerCase()]});
      else if(farea!="" && Cat_Map_Arr[fareaid] && !kw && !loc && exp=='Exp.' && minsal == 'Min' &&  maxsal == 'Max'){
           formname.attr({'action':domain_cat+Cat_Map_Arr[fareaid]});
      }
      //SUDS
      else if(loc!="" ||  kw!=""){
      var action = generateStaticURL(kw,loc);
      formname.attr({'action':domain_cat+action});
      }
      //SUDS

     if(fareaid=='Select')
	selct.options[selct.selectedIndex].value='';
     var selectMax=srcB.eq(7).parent().next().childrens('select').currObj();
     if(selectMax.options[selectMax.selectedIndex].value=='Max')
	selectMax.options[selectMax.selectedIndex].value='';
}

$n.footerCarousel=function(b){var a=this;a.id=b.id;a.s=1E3*b.speed;a.hmm=b.howmanymove;a.li=$n("#"+a.id+" li");a.ul=$n("#"+a.id+" ul");a.li_length=a.li.length;a.li_width=a.li.width();a.countMax=Math.floor(a.li_length/a.hmm);a.countFoot=1;a.globFt=0;a.firstW=a.hmm*a.li_width;a.countDivCrous=a.li_length%4?4*Math.ceil(a.li_length/4):a.li_length;a.countFootNew=0;a.autoMvFt=function(){var b=a.countDivCrous*a.li_width;a.globFt=a.firstW*a.countFoot;a.globFt<b?(b>a.firstW&&(a.countFootNew=0,a.move1ft()),a.countFoot++):(a.countFoot=1,a.globFt=0,a.move2ft());setTimeout(function(){a.autoMvFt()},a.s)};a.move1ft=function(){if(a.countFootNew+a.firstW<a.li_width*a.countDivCrous)return a.globFt>a.countFootNew?(a.ul.css({'left':-a.countFootNew-10+"px"}),a.countFootNew+=10,setTimeout(function(){a.move1ft()},5),!0):!1};a.move2ft=function(){if(a.countFootNew+a.firstW<=a.li_width*a.countDivCrous)return a.globFt<a.countFootNew?(a.ul.css({'left':-a.countFootNew+10+"px"}),a.countFootNew-=10,setTimeout(function(){a.move2ft()},5),!0):!1};a.move1ftM=function(){a.countFootNew+a.firstW<a.li_width*a.countDivCrous&&(1>a.countFoot&&(a.countFoot=1),a.globFt=a.firstW*a.countFoot,a.countFootNew=0,!0==a.move1ft()&&a.countFoot++)};a.move2ftM=function(){a.countFootNew+a.firstW<=a.li_width*a.countDivCrous&&(a.countFoot=1,a.globFt=0,!0==a.move2ft()&&(a.countFoot--,a.globFt=0))};$n("#"+a.id+" .lfic").addEvent("mouseover",a.move2ftM);$n("#"+a.id+" .rfic").addEvent("mouseover",a.move1ftM);setTimeout(function(){a.autoMvFt()},a.s)};
/*footer Carousel*/

var sbDD=function(d){
	var a=this;
	a.id=d.idBand;
	a.bld=$n('#'+a.id+' strong');
	a.s=$n('#'+a.id+' select');
	a.sp=$n('#'+a.id+' span.dd');
	a.inp=a.bld.parents().childrens('input');
  a.inpA=$n('#'+a.id+' input');
	a.cur='';
  a.inpA.eq(2).addEvent('keydown', function(){
    $n(this).parent().parent().parent().childrens('span').removeClass('errIn');
    $n('.errorTxt').html('')
  })
  a.inpA.eq(3).addEvent('keydown', function(){
    $n(this).parent().parent().parent().childrens('span').removeClass('errIn');
    $n('.errorTxt').html('')
  })

	a.sp.addEvent('click', function(e){
    try{
		$n(this).childrens('input').eq(0).currObj().focus();
    }catch(e){}
	})
	a.inp.addEvent('focus', function(e){
		a.cur=$n(this).parent().next();
		a.cur.show().childrens('select').setFocus();
    if($n(this).attr('name')=='jobcat'){
    a.cur.parent().parent().childrens('span').removeClass('errIn')
    $n('.errorTxt').html('')}
	})
	a.s.addEvent('blur', function(e){
		a.cur.hide();
	}).addEvent('click', function(e){
		a.cur.hide();
	}).addEvent('change', function(e){
		maxDD(a.cur, 0)
	}).addEvent('keydown', function(e){
		e=$n(document).ev(e);
		var sftK=e.shiftKey;
		var kC=e.keyCode;
		if(sftK && kC=='9'){
		if(e.preventDefault)
		e.preventDefault() 
		else 
		e.returnValue = false;

			var part=a.cur.parent();
			var b=part.prev().childrens('input');
			if(b.length){
				part.prev().childrens('input').setFocus();
			}
			else{
			part.parent().prev().childrens('input').setFocus();
			}
		}
		else if(kC=='9'){
					if(e.preventDefault)
		e.preventDefault() 
		else 
		e.returnValue = false;

			var part=a.cur.parent();
			
			if(part.next()){
			var b=part.next().childrens('input');
			
			if(b.currObj().nodeName=='INPUT'){
				part.next().childrens('input').setFocus();
			}
			else{
			part.parent().next().childrens('input').setFocus();
			}
			}
			else if(part.parent().next()){
				part.parent().next().childrens('button').setFocus()
			}
		}
		else if(kC=='13'){
			a.cur.hide();
		}
	})
	
}

var maxDD=function(obj, indexVal){
	var t=obj.childrens('select').currObj();
		var str1=t.options[t.selectedIndex].innerHTML;
		var str = str1.replace(/&lt;/,'<',str1);
		str = str.replace(/&gt;/,'>',str);
		str = str.replace(/&amp;/,'&',str);
		var b=obj.parent().childrens('input');
		if(str == "Select" || str == "Max" || str == "Min" || str == "Exp.")
			{
				b.css({'color':"#8D8D8D"})
			}
			else
			{
				b.css({'color':"#333"})
			}
		b.val(str);
    var minS=t.options[0].innerHTML;
    if(minS=='Min'){
      var maxA=getLabelMap['minDD'];
      var selc=obj.parent().next().childrens('select').eq(0)
      selc.html('').parent().parent().hide();
      var opt=$n('<option>').attr({'selected':'selected'}).html('Max');
		selc.append(opt);
		
      var count=2;
      selc.attr({'size':count});
      var maxArr=new Array();
      for(x in maxA){
        if('&lt; .5'==str1 || '&lt .5'==str1){
          maxArr=maxA;
          count=10;
          break;
        }
        else if(parseInt(maxA[x])>=parseInt(str1)){
          maxArr[x]=maxA[x];
          count++;
        }
      }
      if(count!=2){
      maxArr['#10000000']='&gt;50';
      }
      populateSrchBandDD(selc, maxArr, indexVal);
      if(count>10)
      count=10;
      selc.attr({'size':count});
      selc.css({'height':((count==2)? (count-1)*16 : count*16)+'px'})
      delete(maxArr)
	  }
}

/*============================parameters
1.	a.sTextBox = set id of secont text box in which first suggestion will be show
2.	a.typeahead = define it with value true if we have only one text box and show ahead suggestion
3.	a.countSugg = set integer amount to set number of suggestion to be shown
4.	a.domain = set it true if we want to show the suggestion after @
============================================*/
$n.fn.suggester=function(a){
	(a!=undefined && typeof a=='object')?a:a=false;//handling arguments
	var obj=this;
	var obj2=(a.sTextBox)?$n('#'+a.sTextBox):'';(obj2)?obj2.attr('value',''):'';
	var suggCount=(a.countSugg)?a.countSugg:false;
	obj.layer=null;
	obj.layer2=null;
	obj.cur = -1;	
	obj.position=0;	
	obj.suggestions =a.arry;	
	obj.ob=el[0]
	obj.val4='';
	obj.requestSuggestions=function(bTypeAhead){		
		var aSuggestions = [];
		var sTxtValue=obj.attr('value');
		obj.position=$n(obj.ob).position();
		obj.val4='';
		if(sTxtValue.length>0){
			for(var i=0;i<obj.suggestions.length;i++){
				if(a.domain){
					var setTxtVal=sTxtValue.split('@');
					if(obj.suggestions[i].indexOf(setTxtVal[1].toLowerCase())==0){aSuggestions.push(setTxtVal[0]+'@'+obj.suggestions[i])}
					}else{
						var val2=sTxtValue.split(',');
						if(val2[1]){
						obj.val4='';
						sTxtValue=val2[val2.length-1];
						for(var k=0; k<(val2.length-1); k++){
							obj.val4+=$n.trim(val2[k])+', ';
						}
						}
						sTxtValue = sTxtValue.replace(/[@;:!&\s]+/g," ");
                        sTxtValue = sTxtValue.replace(/^\s/,"");
               if(sTxtValue.length>1){
						var getPos=obj.suggestions[i].toLowerCase().indexOf(sTxtValue.toLowerCase());
						if(getPos>=0  && (obj.suggestions[i].charAt(getPos-1) == " " || getPos==0)){
							var e=obj.suggestions[i].substr(getPos, sTxtValue.length)
							var b='<b>'+e+'</b>';
							var c=obj.suggestions[i].split(sTxtValue.toLowerCase());
							var d='';
							if(getPos==0)
							d='';
							else
							d=c[0];
							var kwFlag=0;
							for(var j=1; j<c.length; j++){
								if(!kwFlag){
								d+=b+c[j];
								kwFlag=1;
								}else
								d+=e+c[j];
							}
						aSuggestions.push(d)
						}
					}			}	
				}		
			}
		if((aSuggestions.length>0)&&(suggCount)){aSuggestions=aSuggestions.slice(0,suggCount);}
		obj.autosuggest(aSuggestions,bTypeAhead);	
		}//RequestSuggestion	
	
	obj.autosuggest=function(sSuggestions,bTypeAhead){
		if(sSuggestions.length>0){
			if(bTypeAhead){obj.typeAhead(sSuggestions[0])}
			obj.showSuggestions(sSuggestions);			
			}else {obj.hideSuggestions();}
		}//autosuggest end here	
		
	obj.typeAhead=function(sSuggestions){
		if(obj.currObj().createTextRange||obj.currObj().setSelectionRange){
			if(obj2){obj2.attr('value',sSuggestions)}
			else{var iLen=obj.attr('value').length;			
			obj.attr('value',sSuggestions);	
			obj.selectRange(iLen,sSuggestions.length)}			
			}
		}//typeAhead end here			
	
	obj.selectRange=function(iStart,iEnd){
		if(obj.currObj().createTextRange){
			var oRng=obj.currObj().createTextRange();
			oRng.moveStart('character',iStart);
			oRng.moveEnd('character',iEnd-obj.attr('value').length)
			oRng.select();
			}
		else if(obj.currObj().setSelectionRange){obj.currObj().setSelectionRange(iStart,iEnd)}
		obj.setFocus();		
		}//selectRange end here
	
	obj.handleKeyDown=function(oEvent){
		switch(oEvent.keyCode){
			case 38://up arrow
			obj.previousSuggestion();
			break;	
			case 39://right arrow
			obj.currentSuggestion();
			break;	
			case 40: //down arrow
           	obj.nextSuggestion();
            break;
        	case 13: //enter
			var divObj=obj.layer.childrens('div');
                        for(var i=0; i<divObj.length; i++){
                              var curObj=divObj.eq(i)
                              if(curObj.getStyle(curObj.currObj(), 'visibility')=='visible' && curObj.hasClass('current'))
                                     (oEvent.preventDefault)?oEvent.preventDefault():oEvent.returnValue=false;
                        }
                        obj.hideSuggestions();return false;
			break;			
			}		
		}//handleKeyDown
		
	//console.log(obj.parent().currObj().nodeName);
	obj.handleKeyUp=function(oEvent){		
		var iKeyCode=oEvent.keyCode;
		if (iKeyCode == 8 || iKeyCode == 46) {//backspace and del
		obj.cur=-1;
		(obj2)?obj.requestSuggestions(true):obj.requestSuggestions(false)}
		else if(iKeyCode<32||(iKeyCode>=33&&iKeyCode<=46)||(iKeyCode >= 112 && iKeyCode <= 123)){}
		else {(obj2||a.typeahead)?obj.requestSuggestions(true):obj.requestSuggestions(false)}
		//Handle text 
		//if(obj.attr('value').length==1&&obj.layer.first()&&obj2){obj.cur=0;obj2.attr('value',obj.layer.childrens.eq(0).html())}
		}//handleKeyUp end	
	
	obj.hideSuggestions =function(){// Added for xtra funct.
		obj.layer.html('');
		obj.layer.css({visibility:'hidden'});
		obj.layer2.css({visibility:'hidden'});
		(obj2)?obj2.attr('value',''):'';
		obj.cur=-1;
		}//hideSuggestions
	
	obj.highlightSuggestion=function(oSuggestionNode){// Added for xtra funct.
	    for(var i=0;i<obj.layer.childrens('div').length;i++){
			var oNd=obj.layer.childrens('div').eq(i);
			if(oNd.currObj()==oSuggestionNode.currObj()){oNd.addClass('current')}
			else if(oNd.hasClass('current')){oNd.changeClass('')}
			//if(oNd==oSuggestionNode){oNd.className='current';}
			//else if(oNd.className=='current'){oNd.className=''}
			}
		}//highlightSuggestion
	
	obj.nextSuggestion=function(){		
		var cSuggestionNodes = obj.layer.childrens('div');
		if (cSuggestionNodes.length > 0 && obj.cur < cSuggestionNodes.length-1) {
        var oNode = cSuggestionNodes.eq(++obj.cur);
        obj.highlightSuggestion(oNode);
		obj.attr('value',obj.val4+oNode.text());
		(obj2)?obj2.attr('value',obj.val4+oNode.text()):'';
		}
		else if(cSuggestionNodes.length>0){
			obj.cur=-1;
			var oNode = cSuggestionNodes.eq(++this.cur);
			obj.highlightSuggestion(oNode);
			obj.attr('value',obj.val4+oNode.text());
			(obj2)?obj2.attr('value',obj.val4+oNode.text()):'';
			}		
		}//nextSuggestion
	
	obj.previousSuggestion=function(){
		var cSuggestionNodes = obj.layer.childrens('div');
		obj.cur--;
		if (cSuggestionNodes.length > 0 && obj.cur > -1){
			var oNode = cSuggestionNodes.eq(obj.cur);
			obj.highlightSuggestion(oNode);	
			obj.attr('value',obj.val4+oNode.text());
			(obj2)?obj2.attr('value',obj.val4+oNode.text()):'';
			}
		else if(cSuggestionNodes.length > 0){
			obj.cur=cSuggestionNodes.length-1;
			var oNode = cSuggestionNodes.eq(obj.cur);
			obj.highlightSuggestion(oNode);
			obj.attr('value',obj.val4+oNode.text());
			(obj2)?obj2.attr('value',obj.val4+oNode.text()):'';
			}		
		}//previousSuggestion

	obj.currentSuggestion=function(){
		
		var iCaretPos = 0;
    	if (document.selection) { //for IE
          obj.setFocus ();
          var oSel = document.selection.createRange ();
          oSel.moveStart ('character', -obj.attr('value').length);
          iCaretPos = oSel.text.length;
		  }
    	 // Firefox support
    	 else if (obj.currObj().selectionStart || obj.currObj().selectionStart == '0'){iCaretPos = obj.currObj().selectionStart;}
    	if(obj.attr('value').length==iCaretPos){
		
		if(obj.layer.first()){			
		var cN=obj.layer.childrens('div').eq((obj.cur>=0)?obj.cur:0);
		//cN=(typeof cN=='undefined')?(obj.layer.childrens().eq(0)):cN;
		
		obj.attr('value',cN.text());
		//console.log(obj.attr('value',cN.firstChild.nodeValue))
		(obj2)?obj2.attr('value',cN.text()):'';
		obj.hideSuggestions();}}
		else {return false}
		}//currentSuggestion end here
		
	obj.createDropDown=function(){
		obj.layer=$n('<div>').addClass('suggestions').css({visibility:'hidden',top:'-1000px'});
		//obj.layer=$n('div.suggestions');
		obj.layer2=$n('<iframe>');
		obj.layer2.addClass('suggestions2').css({visibility:'hidden',top:'-1000px'});
		obj.layer2.attr({scrolling:'no',frameborder:'0',marginheight:'0',marginwidth:'0'});
		$n('body').append(obj.layer.currObj());
		$n('body').append(obj.layer2.currObj());
		var events=['mousedown','mouseover','mouseup'];
		for(var i in events){
			(function(){
					  var cevnt=events[i];
					 // obj.layer=$n('.suggestions');
					  obj.layer.addEvent(cevnt,function(oEvent){
						oTarget=$n(oEvent.target||oEvent.srcElement);
						
						if(oEvent.type=='mousedown'){
						obj.attr('value',oTarget.text());
						(obj2)?obj2.attr('value',oTarget.text()):'';
						obj.hideSuggestions();
						}				 
						else if(oEvent.type=='mouseover'){obj.highlightSuggestion(oTarget);	}	
						else {obj.setFocus()}
						});				  
					  })();	
			}
		}//createDropDown
	
	obj.showSuggestions=function(aSuggestions){
		var oDiv=null;
		//obj.layer=$n('.suggestions');
		//obj.layer2=$n('.suggestions2');
		obj.layer.html('');
		for(var i=0;i<aSuggestions.length;i++){
			
			oDiv=$n('<div>').append(aSuggestions[i]);			
			obj.layer.append(oDiv.currObj());
			
			}	
	
		obj.layer.css({left:obj.position.left+'px',top:(obj.position.top+obj.height())+'px',width:obj.width()+'px',visibility:'visible'});
		obj.layer2.css({left:obj.position.left+'px',top:(obj.position.top+obj.height())+'px',width:obj.width()+'px',height:obj.layer.height()+'px',visibility:'visible'})
		}//showSuggestions
	obj.init=function(){
		var oEvent=(!oEvent)?window.event:oEvent;
		obj.addEvent('keyup',function(oEvent){
									  if(a.domain){
									 var reg=/\@[A-Z,0-9,a-z]{1}/;
									 var objVal=obj.attr('value');
									if(!reg.test(objVal)){obj.hideSuggestions();return false;}
									  }
									  obj.handleKeyUp(oEvent);									  
									  }).addEvent('keydown',function(oEvent){obj.handleKeyDown(oEvent)}).addEvent('blur',function(){obj.hideSuggestions()});
			obj.createDropDown();		
		
		}//init function end here	
	obj.init();	
	}//suggester end here
var srpDefaultText=function(obj, txt){
                if(obj.val()==txt){
                                obj.val('').css({'color':'#333'});
                }
                else if(obj.val()==''){
                                obj.val(txt).css({'color':'#8d8d8d'});
                }else{
                                obj.css({'color':'#333'});
                }
}
