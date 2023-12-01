/**
 * $Id: nm_gauge.js,v 1.1.1.1 2011-05-12 20:31:29 diogo Exp $
 */
 function nmGauge(sName, sTitle, iSize, iMsg)
 {
  // Propriedades
  this.image_dir    = '';
  this.msg_header   = '';
  this.name         = sName;
  this.now_size     = 0;
  this.now_step     = 0;
  this.perc         = 0;
  this.size         = iSize;
  this.status       = false;
  this.steps        = 0;
  this.title        = sTitle;
 
  // Metodos Privados
  this.DrawBar      = DrawBar;
  this.GetBarSize   = GetBarSize;
  this.GetImageDir  = GetImageDir;
  this.GetMsgHeader = GetMsgHeader;
  this.GetName      = GetName;
  this.GetPerc      = GetPerc;
  this.GetSize      = GetSize;
  this.GetSteps     = GetSteps;
  this.GetTitle     = GetTitle;
  this.IncStep      = IncStep;
  this.SetOk        = SetOk;
  this.ShowTitle    = ShowTitle;
 
   // Metodos Publicos
  this.Finalize     = Finalize;
  this.Init         = Init;
  this.IsOk         = IsOk;
  this.SetMsgHeader = SetMsgHeader;
  this.Step         = Step;
 
  // Desenha Barra
  this.DrawBar(iMsg);
 }
 
 
 // Metodos Privados
 function DrawBar(iMsg)
 {   
    if(this.GetName() == 'pb'){
        document.write('<div id="panel_' + this.GetName() + '" style="display: flex;flex-flow: column nowrap;justify-content: center;align-items: center;row-gap: 1rem;margin-top: 1.5rem;">');
    }else{
        document.write('<div id="panel_' + this.GetName() + '">');   
    }      
    document.write('    <div class="" style="width: 500px;">');
    document.write('        <div class="ui segments">');
    document.write('            <div class="ui segment">');
    document.write('                '+this.GetTitle());
    document.write('            </div>');
    document.write('            <div class="ui padded segment">');
    document.write('                <div class="demo-wrapper html5-progress-bar">');
    document.write('                    <div class="progress-bar-wrapper">');
    document.write('                        <progress id="perc_' + this.GetName() + '_value" value="0" max="100"></progress>');
    document.write('                        <span id="perc_' + this.GetName() + '" class="progress-value">'+ this.GetPerc()+'%</span>');
    document.write('                    </div> ');
    document.write('                    <div id="finish_progress_'+this.GetName()+'" class="ui success message small" style="display:none; margin-top: 1.75rem;">  ');
    document.write('                        <div class="header">');
    document.write('                            '+iMsg);
    document.write('                        </div>');
    document.write('                    </div>');
    document.write('                    <div class="marginTop-m" id="msg_' + this.GetName() + '">'+iMsg+'</div>');
    document.write('                </div>');
    document.write('            </div>');
    document.write('            <div id="id_div_button_download" class="ui secondary segment">');
    document.write('                <a class="ui button primary compact disabled" id="id_pub_button_download">Download</a>');
    document.write('            </div>');
    document.write('        </div>');
    document.write('    </div>');
    document.write('</div>');
 }
 
 function GetBarSize()
 {
  return this.now_size;
 }
 
 function GetMsgHeader()
 {
  return this.msg_header;
 }
 
 function GetImageDir()
 {
  return this.image_dir;
 }
 
 function GetName()
 {
  return this.name;
 }
 
 function GetPerc()
 {
  return this.perc;
 }
 
 function GetSize()
 {
  return this.size;
 }
 
 function GetSteps()
 {
  return this.steps;
 }
 
 function GetTitle()
 {
  return this.title;
 }
 
 function IncStep(iStep)
 {
  this.now_step = iStep;
  this.now_size = Math.round((this.now_step * this.GetSize()) / this.GetSteps());
  this.perc     = Math.round((this.now_step * 100) / this.GetSteps());
 }
 
 function SetOk()
 {
  this.status = true;
 }
 
 function ShowTitle()
 {
  return ('' != this.title);
 }
 
 // Metodos Publicos
 function Finalize(sMsg)
 {
  document.getElementById('perc_' + this.GetName() + '_value').value        = 100;
  document.getElementById('perc_' + this.GetName()).innerHTML               = '100%';
  document.getElementById('msg_'  + this.GetName()).style.display           = "none";
  document.getElementById('msg_'  + this.GetName()).innerHTML               = this.GetMsgHeader() + sMsg;
  document.getElementById('finish_progress_'+this.GetName()).innerHTML      = this.GetMsgHeader() + sMsg;
  document.getElementById('finish_progress_'+this.GetName()).style.display  = "";
  

 }
 
 function Init(iSteps, sImgDir)
 {
  this.steps     = iSteps;
  this.SetOk();
  document.write('<style>.html5-progress-bar progress{background-color:#f3f3f3;border:0;width:87%;height:24px;border-radius:9px}.html5-progress-bar progress::-webkit-progress-bar{background-color:#f3f3f3;border-radius:9px}.html5-progress-bar progress::-webkit-progress-value{background:#2574a9;background:-moz-linear-gradient(top,#2574a9 0,#2574b9 100%);background:-webkit-gradient(linear,left top,left bottom,color-stop(0,#2574a9),color-stop(100%,#2574b9));background:-webkit-linear-gradient(top,#2574a9 0,#2574b9 100%);background:-o-linear-gradient(top,#2574a9 0,#2574b9 100%);background:-ms-linear-gradient(top,#2574a9 0,#2574b9 100%);background:linear-gradient(to bottom,#2574a9 0,#2574b9 100%);border-radius:9px}.html5-progress-bar progress::-moz-progress-bar{background:#2574a9;background:-moz-linear-gradient(top,#2574a9 0,#2574b9 100%);background:-webkit-gradient(linear,left top,left bottom,color-stop(0,#2574a9),color-stop(100%,#2574b9));background:-webkit-linear-gradient(top,#2574a9 0,#2574b9 100%);background:-o-linear-gradient(top,#2574a9 0,#2574b9 100%);background:-ms-linear-gradient(top,#2574a9 0,#2574b9 100%);background:linear-gradient(to bottom,#2574a9 0,#2574b9 100%);border-radius:9px}.progress-bar-wrapper{display:flex;flex-flow:row nowrap;justify-content:center;align-items:center;column-gap:.5rem}.html5-progress-bar .progress-value{font-size:.95rem;color:#555;font-weight:700}</style>');
 }
 
 function IsOk()
 {
  return this.status;
 }
 
 function SetMsgHeader(sMsg)
 {
  this.msg_header = sMsg;
 }
 
 function Step(sMsg, iStep)
 {
  this.IncStep(iStep);
  document.getElementById('perc_' + this.GetName() + '_value').value  = this.GetPerc();
  document.getElementById('perc_' + this.GetName()).innerHTML         = this.GetPerc()+'%';
  document.getElementById('msg_'  + this.GetName()).innerHTML         = this.GetMsgHeader() + sMsg;
 }
 
 