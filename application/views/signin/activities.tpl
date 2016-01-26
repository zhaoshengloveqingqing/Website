{extends file='base_layout.tpl'}
{block name=head}{css}{/block}
{block name=body}
    <div class="container">
        {header}
            <div id="head" class="row">
                {figure action='http://www.pinet.co' path='/responsive/size' class='col-320-4 col-1280-3' src=$logo title=$company}
                {/figure}
                {h1 class='col-320-8 col-1280-9'}{$company} {lang}activities{/lang}{/h1}
            </div>        
        {/header}
        {sect name='buttons'}
            <div id="content" class="row">
                <div class="col-320-12 col-1280-6">
                    <div id='left_activities' class="row">

                        {foreach $activities as $key => $activitie}
                        {if $key==0 && isset($activitie['photo'])}
                        <div class="list large col-1280-12">
                            {picture path='/responsive/size' class='col-480-12 col-1280-10' alt=$company src=$activitie['photo']}
                            <div class='activitie-info'>
                                    <h3>{$activitie['title']}</h3>
                                    {$activitie['contents']}
                            </div>    
                        </div><!-- end -->
                        {/if}                      
                        {if  $key == 1 && isset($activitie['photo'])}
                        <div class="list simple col-1280-12">
                            <ul>
                                <li>
                                    <div class="activitie-logo">
                                        {picture path='/responsive/size' class='col-480-12 col-1280-12' alt=$company src=$activitie['photo']}
                                    </div>                                
                                </li>
                                <li>
                                    <div class='activitie-info'>
                                        <h3>{$activitie['title']}</h3>
                                        {$activitie['contents']}
                                    </div>                                
                                </li>
                            </ul>
                        </div><!-- end -->    
                        {/if}                            
                        {/foreach}                      
                    </div>                 
                </div><!-- end left -->
                <div class="col-320-12 col-1280-6">
                    <div id='right_activities' class="row">
                            {foreach $activities as $key => $activitie}
                                {if  $key>1 && isset($activitie['photo'])}
                                <div class="list simple col-1280-12">
                                    <ul>
                                        <li>
                                            <div class="activitie-logo">
                                                {picture path='/responsive/size' class='col-480-12 col-1280-12' alt=$company src=$activitie['photo']}
                                            </div>                                
                                        </li>
                                        <li>
                                            <div class='activitie-info'>
                                                <h3>{$activitie['title']}</h3>{$activitie['contents']}
                                            </div>                                
                                        </li>
                                    </ul>
                                </div><!-- end -->
                                {/if}                            
                            {/foreach}          
                    </div>                                 
                </div>
            </div>
        {/sect}  
        {footer}
            <div id="foot">
                <div id="legal">
                    {lang}Provide to you by{/lang}{link uri='http://www.pinet.co'}{figure src='pinet_footer_logo.png' media320='32' media480='48' media640='64'  media720='72'}{/figure}{/link}{lang}Suzhou Pinet Network Technology Co., Ltd. to provide technical support{/lang}
                </div>
            </div>
        {/footer}            
    </div>
{/block}
{block name=foot}
{js}
{/block}