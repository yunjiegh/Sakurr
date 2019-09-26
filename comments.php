<?php
 
	/**
	 * COMMENTS TEMPLATE
	 */

	/*if('comments.php' == basename($_SERVER['SCRIPT_FILENAME']))
		die(esc_html__('Please do not load this page directly.', 'akina'));*/

	if(post_password_required()){
		return;
	}

?>

	<?php if(comments_open()): ?>

	<section id="comments" class="comments">

		<div class="commentwrap comments-hidden">
			<div class="notification"><i class="iconfont icon-mark"></i><?php esc_html_e('查看评论', 'akina'); ?> -
			<span class="noticom"><?php comments_number('NOTHING', '1 条评论', '% 条评论'); ?> </span>
			</div>
		</div>

		<div class="comments-main">
		 <h3 id="comments-list-title">Comments | <span class="noticom"><?php comments_number('NOTHING', '1 条评论', '% 条评论'); ?> </span></h3> 
		<div id="loading-comments"><span></span></div>
			<?php if(have_comments()): ?>

				<ul class="commentwrap">
					<?php wp_list_comments('type=comment&callback=akina_comment_format'); ?>	
				</ul>

          <nav id="comments-navi">
				<?php paginate_comments_links('prev_text=« Older&next_text=Newer »');?>
			</nav>

			 <?php else : ?>

				<?php if(comments_open()): ?>
					<div class="commentwrap">
						<div class="notification-hidden"><i class="iconfont icon-mark"></i> <?php esc_html_e('暂无评论', 'akina'); ?></div>
					
					</div>
				<?php endif; ?>

			<?php endif; ?>

			<?php

				if(comments_open()){
					if(akina_option('norobot')) $robot_comments = '<label class="siren-checkbox-label"><input class="siren-checkbox-radio" type="checkbox" name="no-robot"><span class="siren-no-robot-checkbox siren-checkbox-radioInput"></span>滴，学生卡 | I\'m not a robot</label>';
					$private_ms = akina_option('open_private_message') ? '<label class="siren-checkbox-label"><input class="siren-checkbox-radio" type="checkbox" name="is-private"><span class="siren-is-private-checkbox siren-checkbox-radioInput"></span>悄悄话 | Comment in private</label>' : '';
					$args = array(
						'id_form' => 'commentform',
						'id_submit' => 'submit',
						'title_reply' => '',
						'title_reply_to' => '<div class="graybar"><i class="fa fa-comments-o"></i>' . esc_html__('Leave a Reply to', 'akina') . ' %s' . '</div>',
						'cancel_reply_link' => esc_html__('Cancel Reply', 'akina'),
						'label_submit' => esc_html__('BiuBiuBiu~', 'akina'),
						'comment_field' => '<p><i class="iconfont icon-markdown"></i> Markdown Supported while <i class="fa fa-code" aria-hidden="true"></i> Forbidden</p><div class="comment-textarea"><textarea placeholder="' . esc_attr__('你是我一生只会遇见一次的惊喜', 'akina') . ' ..." name="comment" class="commentbody" id="comment" rows="5" tabindex="4"></textarea><label class="input-label">你是我一生只会遇见一次的惊喜 ...</label></div>
                        <div id="upload-img-show"></div>
                        <!--插入表情面版-->
                        <p id="emotion-toggle" class="no-select">
                            <span class="emotion-toggle-off">戳我试试 OωO</span>
                            <span class="emotion-toggle-on">嘿嘿嘿 ヾ(≧∇≦*)ゝ</span>
                        </p>
                        <div class="emotion-box no-select">
                            <table class="motion-switcher-table">
                                <tr>
                                    <th onclick="motionSwitch(\'.bili\')" 
                                        class="bili-bar on-hover">bilibili~</th>
                                    <th onclick="motionSwitch(\'.menhera\')"
                                        class="menhera-bar">(=・ω・=)</th>
                                    <th onclick="motionSwitch(\'.tieba\')"
                                        class="tieba-bar">Tieba</th>
                                </tr>
                            </table>
                            <div class="bili-container motion-container">' . push_bili_smilies() . '</div>
                            <div class="menhera-container motion-container" style="display:none;">
                                '.push_emoji_panel().'
                            </div>
                            <div class="tieba-container motion-container" style="display:none;">' . push_smilies() . '</div>
                        </div>
                        <!--表情面版完-->',
						'comment_notes_after' => '',
						'comment_notes_before' => '',
						'fields' => apply_filters( 'comment_form_default_fields', array(
                            'avatar' => '<div class="cmt-info-container"><div class="comment-user-avatar"><img src="https://gravatar.shino.cc/avatar/f11f237b3de93c93b24045e71f7f65c6?s=80&d=mm&r=g"><div class="socila-check qq-check"><i class="fa fa-qq" aria-hidden="true"></i></div><div class="socila-check gravatar-check"><i class="fa fa-google" aria-hidden="true"></i></div></div>',
							'author' =>
								'<div class="popup cmt-popup cmt-author" onclick="cmt_showPopup(this)"><span class="popuptext" id="thePopup" style="margin-left: -115px;width: 230px;">输入QQ号将自动拉取昵称和头像</span><input type="text" placeholder="' . esc_attr__('昵称或QQ号', 'akina') . ' ' . ( $req ?  '(' . esc_attr__('必须 Name* ', 'akina') . ')' : '') . '" name="author" id="author" value="' . esc_attr($comment_author) . '" size="22" autocomplete="off" tabindex="1" ' . ($req ? "aria-required='true'" : '' ). ' /></div>',
							'email' =>
								'<div class="popup cmt-popup" onclick="cmt_showPopup(this)"><span class="popuptext" id="thePopup" style="margin-left: -65px;width: 130px;">你将收到回复通知</span><input type="text" placeholder="' . esc_attr__('邮箱', 'akina') . ' ' . ( $req ? '(' . esc_attr__('必须 Email* ', 'akina') . ')' : '') . '" name="email" id="email" value="' . esc_attr($comment_author_email) . '" size="22" tabindex="1" autocomplete="off" ' . ($req ? "aria-required='true'" : '' ). ' /></div>',
							'url' =>
								'<div class="popup cmt-popup" onclick="cmt_showPopup(this)"><span class="popuptext" id="thePopup" style="margin-left: -55px;width: 110px;">禁止小广告😀</span><input type="text" placeholder="' . esc_attr__('网站 (选填 Site)', 'akina') . '" name="url" id="url" value="' . esc_attr($comment_author_url) . '" size="22" autocomplete="off" tabindex="1" /></div></div>' . $robot_comments . $private_ms ,
                            'qq' =>
								'<input type="text" placeholder="' . esc_attr__('QQ', 'akina') . '" name="new_field_qq" id="qq" value="' . esc_attr($comment_author_url) . '" style="display:none" autocomplete="off"/><!--此栏不可见-->'
							)
						)
					);
					comment_form($args);
				}

			?>

		</div>


	</section>
<?php endif; ?>
