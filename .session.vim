let SessionLoad = 1
if &cp | set nocp | endif
let s:so_save = &so | let s:siso_save = &siso | set so=0 siso=0
let v:this_session=expand("<sfile>:p")
silent only
if expand('%') == '' && !&modified && line('$') <= 1 && getline(1) == ''
  let s:wipebuf = bufnr('%')
endif
set shortmess=aoO
badd +106 /Applications/XAMPP/xamppfiles/htdocs/dbproj/db.php
badd +84 /Applications/XAMPP/xamppfiles/htdocs/dbproj/helpers.php
badd +27 /Applications/XAMPP/xamppfiles/htdocs/dbproj/create.sql
badd +87 /Applications/XAMPP/xamppfiles/htdocs/dbproj/index.php
badd +223 /Applications/XAMPP/xamppfiles/htdocs/dbproj/forms.php
badd +40 /Applications/XAMPP/xamppfiles/htdocs/dbproj/login.php
badd +214 /Applications/XAMPP/xamppfiles/htdocs/dbproj/page_base.php
badd +265 /Applications/XAMPP/xamppfiles/htdocs/dbproj/dom.php
badd +37 /Applications/XAMPP/xamppfiles/htdocs/dbproj/logout.php
badd +0 /Applications/XAMPP/xamppfiles/htdocs/dbproj/business.php
badd +26 /Applications/XAMPP/xamppfiles/htdocs/dbproj/prefs.php
argglobal
silent! argdel *
edit /Applications/XAMPP/xamppfiles/htdocs/dbproj/business.php
set splitbelow splitright
wincmd _ | wincmd |
vsplit
1wincmd h
wincmd w
set nosplitbelow
set nosplitright
wincmd t
set winheight=1 winwidth=1
wincmd =
argglobal
let s:l = 26 - ((8 * winheight(0) + 22) / 44)
if s:l < 1 | let s:l = 1 | endif
exe s:l
normal! zt
26
normal! 05|
wincmd w
argglobal
edit /Applications/XAMPP/xamppfiles/htdocs/dbproj/page_base.php
let s:l = 113 - ((24 * winheight(0) + 24) / 48)
if s:l < 1 | let s:l = 1 | endif
exe s:l
normal! zt
113
normal! 020|
wincmd w
2wincmd w
wincmd =
if exists('s:wipebuf')
  silent exe 'bwipe ' . s:wipebuf
endif
unlet! s:wipebuf
set winheight=1 winwidth=20 shortmess=filnxtToOc
let s:sx = expand("<sfile>:p:r")."x.vim"
if file_readable(s:sx)
  exe "source " . fnameescape(s:sx)
endif
let &so = s:so_save | let &siso = s:siso_save
doautoall SessionLoadPost
unlet SessionLoad
" vim: set ft=vim :
