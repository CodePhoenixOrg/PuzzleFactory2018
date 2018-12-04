set nocompatible
let s:cpo_save=&cpo
set cpo&vim
map! <S-Insert> <MiddleMouse>
map! <xHome> <Home>
map! <xEnd> <End>
map! <S-xF4> <S-F4>
map! <S-xF3> <S-F3>
map! <S-xF2> <S-F2>
map! <S-xF1> <S-F1>
map! <xF4> <F4>
map! <xF3> <F3>
map! <xF2> <F2>
map! <xF1> <F1>
map Q gq
map <S-Insert> <MiddleMouse>
map <xHome> <Home>
map <xEnd> <End>
map <S-xF4> <S-F4>
map <S-xF3> <S-F3>
map <S-xF2> <S-F2>
map <S-xF1> <S-F1>
map <xF4> <F4>
map <xF3> <F3>
map <xF2> <F2>
map <xF1> <F1>
let &cpo=s:cpo_save
unlet s:cpo_save
set backspace=indent,eol,start
set backup
set history=50
set hlsearch
set iminsert=0
set incsearch
set mouse=a
set ruler
set showcmd
if &syntax != 'javascript'
set syntax=javascript
endif
set termencoding=utf-8
let s:so_save = &so | let s:siso_save = &siso | set so=0 siso=0
let v:this_session=expand("<sfile>:p")
silent only
cd ~/
set shortmess=aoO
badd +146 /var/www/html/factory/fr/mkscripts.php
badd +22 /var/www/html/puzzle/page.php
badd +373 /var/www/html/puzzle/includes/pz_menus.php
badd +7 /var/www/html/factory/pz_defaults.php
badd +30 /var/www/html/puzzle/includes/pz_blocks.php
badd +1163 /var/www/html/puzzle/includes/pz_db_controls.php
badd +128 /var/www/html/puzzle/includes/pz_mkscripts.php
badd +1 /var/www/html/factory/fr/edit.php
badd +9 /var/www/html/factory/fr/edscripts.php
badd +37 /var/www/html/factory/index.php
badd +100 /var/www/html/factory/page.php
badd +57 /var/www/html/factory/fr/diary.php
badd +34 /var/www/html/puzzle/includes/pz_analyser.php
badd +61 /var/www/html/factory/fr/dictionary.php
badd +216 /var/www/html/puzzle/includes/pz_db.php
badd +15 /var/www/html/exp/field_labels.php
badd +85 /var/www/html/factory/fr/changelog.php
badd +12 /var/www/html/exp/analyser/index.php
badd +171 /var/www/html/puzzle/includes/pz_design.php
badd +108 /var/www/html/factory/fr/menus.php
badd +106 /var/www/html/factory/fr/todo.php
badd +91 www/factory/fr/bugreport.php
badd +58 www/puzzle/js/pz_design.js
badd +19 www/puzzle/includes/pz_controls.php
args /var/www/html/puzzle/page.php
set splitbelow splitright
set nosplitbelow
set nosplitright
wincmd t
set winheight=1 winwidth=1
argglobal
edit www/puzzle/js/pz_design.js
setlocal noarabic
setlocal noautoindent
setlocal autoread
setlocal nobinary
setlocal bufhidden=
setlocal buflisted
setlocal buftype=
setlocal nocindent
setlocal cinkeys=0{,0},0),:,0#,!^F,o,O,e
setlocal cinoptions=
setlocal cinwords=if,else,while,do,for,switch
setlocal comments=s1:/*,mb:*,ex:*/,://,b:#,:%,:XCOMM,n:>,fb:-
setlocal commentstring=/*%s*/
setlocal complete=.,w,b,u,t,i
setlocal nocopyindent
setlocal define=
setlocal dictionary=
setlocal nodiff
setlocal equalprg=
setlocal errorformat=
setlocal noexpandtab
if &filetype != 'javascript'
setlocal filetype=javascript
endif
setlocal foldcolumn=0
setlocal foldenable
setlocal foldexpr=0
setlocal foldignore=#
setlocal foldlevel=0
setlocal foldmarker={{{,}}}
setlocal foldmethod=manual
setlocal foldminlines=1
setlocal foldnestmax=20
setlocal foldtext=foldtext()
setlocal formatoptions=tcq
setlocal grepprg=
setlocal iminsert=0
setlocal imsearch=2
setlocal include=
setlocal includeexpr=
setlocal indentexpr=
setlocal indentkeys=0{,0},:,0#,!^F,o,O,e
setlocal noinfercase
setlocal iskeyword=@,48-57,_,192-255
setlocal keymap=
setlocal keywordprg=
setlocal nolinebreak
setlocal nolisp
setlocal nolist
setlocal makeprg=
setlocal matchpairs=(:),{:},[:]
setlocal modeline
setlocal modifiable
setlocal nrformats=octal,hex
setlocal nonumber
setlocal path=
setlocal nopreserveindent
setlocal nopreviewwindow
setlocal noreadonly
setlocal norightleft
setlocal rightleftcmd=search
setlocal noscrollbind
setlocal shiftwidth=8
setlocal noshortname
setlocal nosmartindent
setlocal softtabstop=0
setlocal suffixesadd=
setlocal swapfile
if &syntax != 'javascript'
setlocal syntax=javascript
endif
setlocal tabstop=8
setlocal tags=
setlocal textwidth=0
setlocal thesaurus=
setlocal nowinfixheight
setlocal wrap
setlocal wrapmargin=0
silent! normal! zE
let s:l = 37 - ((0 * winheight(0) + 18) / 36)
if s:l < 1 | let s:l = 1 | endif
exe s:l
normal! zt
37
normal! 02l
set winheight=1 winwidth=20 shortmess=filnxtToO
let s:sx = expand("<sfile>:p:r")."x.vim"
if file_readable(s:sx)
  exe "source " . s:sx
endif
let &so = s:so_save | let &siso = s:siso_save
