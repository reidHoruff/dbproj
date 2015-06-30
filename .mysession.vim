let SessionLoad = 1
if &cp | set nocp | endif
let s:so_save = &so | let s:siso_save = &siso | set so=0 siso=0
let v:this_session=expand("<sfile>:p")
silent only
if expand('%') == '' && !&modified && line('$') <= 1 && getline(1) == ''
  let s:wipebuf = bufnr('%')
endif
set shortmess=aoO
badd +8 /var/www/html/dbproj/index.php
badd +46 /var/www/html/dbproj/page_base.php
badd +1 /var/www/html/dbproj/dom.php
badd +1 /var/www/html/dbproj/helpers.php
badd +7 /var/www/html/dbproj/lists.php
badd +1 /var/www/html/dbproj/db.php
badd +274 /var/www/html/dbproj/forms.php
badd +4 /var/www/html/dbproj/prefs.php
badd +1 /var/www/html/dbproj/login.php
badd +1 /var/www/html/dbproj/logout.php
badd +145 /var/www/html/dbproj/res/style.css
badd +4 /var/www/html/dbproj/val.php
badd +1 /var/www/html/dbproj/deploy.sh
argglobal
silent! argdel *
edit /var/www/html/dbproj/logout.php
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
let s:l = 10 - ((9 * winheight(0) + 26) / 52)
if s:l < 1 | let s:l = 1 | endif
exe s:l
normal! zt
10
normal! 023|
wincmd w
argglobal
edit /var/www/html/dbproj/logout.php
let s:l = 25 - ((23 * winheight(0) + 26) / 52)
if s:l < 1 | let s:l = 1 | endif
exe s:l
normal! zt
25
normal! 0
wincmd w
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
