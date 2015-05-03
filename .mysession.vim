let SessionLoad = 1
if &cp | set nocp | endif
let s:so_save = &so | let s:siso_save = &siso | set so=0 siso=0
let v:this_session=expand("<sfile>:p")
silent only
if expand('%') == '' && !&modified && line('$') <= 1 && getline(1) == ''
  let s:wipebuf = bufnr('%')
endif
set shortmess=aoO
badd +47 /var/www/html/dbproj/index.php
badd +47 /var/www/html/dbproj/page_base.php
badd +6 /var/www/html/dbproj/dom.php
badd +1 /var/www/html/dbproj/helpers.php
badd +4 /var/www/html/dbproj/lists.php
badd +44 /var/www/html/dbproj/db.php
badd +281 /var/www/html/dbproj/forms.php
badd +77 /var/www/html/dbproj/prefs.php
argglobal
silent! argdel *
edit /var/www/html/dbproj/prefs.php
set splitbelow splitright
set nosplitbelow
set nosplitright
wincmd t
set winheight=1 winwidth=1
argglobal
let s:l = 90 - ((11 * winheight(0) + 23) / 46)
if s:l < 1 | let s:l = 1 | endif
exe s:l
normal! zt
90
normal! 07|
if exists('s:wipebuf')
  silent exe 'bwipe ' . s:wipebuf
endif
unlet! s:wipebuf
set winheight=1 winwidth=20 shortmess=filnxtToO
let s:sx = expand("<sfile>:p:r")."x.vim"
if file_readable(s:sx)
  exe "source " . fnameescape(s:sx)
endif
let &so = s:so_save | let &siso = s:siso_save
doautoall SessionLoadPost
unlet SessionLoad
" vim: set ft=vim :
