let SessionLoad = 1
if &cp | set nocp | endif
let s:so_save = &so | let s:siso_save = &siso | set so=0 siso=0
let v:this_session=expand("<sfile>:p")
silent only
if expand('%') == '' && !&modified && line('$') <= 1 && getline(1) == ''
  let s:wipebuf = bufnr('%')
endif
set shortmess=aoO
badd +31 /Applications/XAMPP/xamppfiles/htdocs/dbproj/db.php
badd +17 /Applications/XAMPP/xamppfiles/htdocs/dbproj/create.sql
badd +69 /Applications/XAMPP/xamppfiles/htdocs/dbproj/index.php
badd +1 ~/.vimrc
badd +41 /Applications/XAMPP/xamppfiles/htdocs/dbproj/style.css
badd +1 /Applications/XAMPP/xamppfiles/htdocs/dbproj/create.sh
badd +67 /Applications/XAMPP/xamppfiles/htdocs/dbproj/helpers.php
badd +52 /Applications/XAMPP/xamppfiles/htdocs/dbproj/forms.php
badd +72 /Applications/XAMPP/xamppfiles/htdocs/dbproj/dom.php
argglobal
silent! argdel *
edit /Applications/XAMPP/xamppfiles/htdocs/dbproj/forms.php
set splitbelow splitright
set nosplitbelow
set nosplitright
wincmd t
set winheight=1 winwidth=1
argglobal
let s:l = 77 - ((20 * winheight(0) + 21) / 42)
if s:l < 1 | let s:l = 1 | endif
exe s:l
normal! zt
77
normal! 026|
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
