<?php

    print('connected to the database!!<br>');
		
		
   if(@$_POST){
    
     if(@$_POST['edit']){
					$where = "WHERE mu.id =".$_POST['edit'];
          
          $sql = "SELECT mu.*,du.*
								FROM dt_user AS du
								LEFT JOIN mt_pref AS mp ON du.pref = mp.id
								LEFT JOIN mt_user AS mu ON mu.id = du.user_id ".$where;
              
          $sth = $dbh->prepare($sql);         // SQL準備
          $sth->execute();                    // 実行
          $edit = $sth->fetchAll(PDO::FETCH_ASSOC);
				} elseif(@$_POST['id']) {
          $sql01 = "UPDATE dt_user SET name = '".$_POST['name']."',
                                    zip = '".$_POST['zip']."',
                                    address1 = '".$_POST['address1']."',
                                    address2 = '".$_POST['address2']."',
                                    address3 = '".$_POST['address3']."'
                                    WHERE user_id = ".$_POST['id'].";";
                          
                                      
          $sql02 = "UPDATE mt_user SET  login_id = '".$_POST['email']."',
                                    login_password = '".$_POST['password']."'
                                    WHERE id = ".$_POST['id'].";";
          $sth = $dbh->prepare($sql01);
          $sth->execute();
          $sth = $dbh->prepare($sql02);// SQL準備
          $sth->execute();

        ?>
            <script>
              location.href = 'tables-data.php';
            </script>
        <?php
        } else {
    
          $sql = "insert into mt_user(login_id, login_password)
                  values('".$_POST['email']."','".$_POST['password']."')";
          $sth = $dbh->prepare($sql);         // SQL準備
          $sth->execute();
          
          $sql = "select max(id) as id from mt_user";
          $sth = $dbh->prepare($sql);
          $sth->execute();
          while($buff = $sth->fetch(PDO::FETCH_ASSOC)){
          $insert_id=$buff['id'];
          break;
        }
      
      

        }
    }?>

 
<body>

  <!-- ======= Header ======= -->
  <header id="header" class="header fixed-top d-flex align-items-center">


    <nav class="header-nav ms-auto">
    </nav><!-- End Icons Navigation -->

  </header><!-- End Header -->

  <main id="main" class="main">

    <div class="pagetitle">
      <h1>アカウントを作ります</h1>
      <nav>
        <ol class="breadcrumb">
          <li class="breadcrumb-item"><a href="index.html">Home</a></li>
          <li class="breadcrumb-item">Forms</li>
          <li class="breadcrumb-item active">アカウント新規作成</li>
        </ol>
      </nav>
    </div><!-- End Page Title -->
    <section class="section">
      <div class="row">
        <div class="col-lg-12">

          <div class="card">
            <div class="card-body">

              <!-- Multi Columns Form -->
              <form class="row g-3" id="signUp_form" action="forms.php" method="post">
                <input type="hidden" name="id" value="{{ @$edit[0]['id'] }}">
                <div class="col-md-12">
                  <label for="inputName5" class="form-label">お名前</label>
                  <input type="text" id="name" class="form-control" name="name" value="<?= @$edit[0]['name']?>">
                </div>
                <div class="col-md-6">
                  <label for="inputEmail5" class="form-label">メールアドレス</label>
                  <input type="email" id="email" class="form-control" name="email" value="<?= @$edit[0]['login_id']?>">
                </div>
                <div class="col-md-6">
                  <label for="inputPassword5" class="form-label">パスワード</label>
                  <input type="password" id="password" class="form-control" name="password" value="<?= @$edit[0]['login_password']?>">
                </div>
                <div class="col-md-2">
                  <label for="inputZip" class="form-label">郵便番号</label>
                  <input type="text" id="zip" class="form-control" name="zip" value="<?= @$edit[0]['zip']?>">
                </div>
                <div class="col-md-6">
                  <label for="inputCity" class="form-label">都道府県</label>
                  <select class="form-select" name="prefName" id="prefName" value="<?= @$edit[0]['pref']?>">
                    <?php
                           
                    ?>
                    <option value="<?= @$buff['id'] ?>" <?php if(@$buff['id'] == @$edit[0]['pref']){?> selected <?php } ?>><?= @$buff['name']?></option>
                    <!--$buffのidと$editのprefが同じだったらselectedする-->

                  </select>
                </div>
                <div class="col-md-6">
                  <label for="inputCity" class="form-label">市区町村</label>
                  <input type="text" id="address3" class="form-control" name="address1" value="<?= @$edit[0]['address1']?>">
                </div>
                <div class="col-12">
                  <label for="inputAddress5" class="form-label">住所</label>
                  <input type="text" id="address1" class="form-control" name="address2" value="<?= @$edit[0]['address2']?>">
                </div>
                <div class="col-12">
                  <label for="inputAddress2" class="form-label">住所 2</label>
                  <input type="text" id="address2" class="form-control" name="address3" value="<?= @$edit[0]['address3']?>">
                </div>
                
                
                <div class="col-12">
                  <div class="form-check">
                    
                    <label class="form-check-label" for="gridCheck">
                      プライバシーポリシー
                    </label>
                  </div>
                </div>
                <div class="text-center">
                  <!-- 送信ボタン -->
	                <div class="text-center">
	                  <button type="submit" id="submit_btn" class="btn btn-primary">Submit</button>
	                  <button type="reset" class="btn btn-secondary">Reset</button>
	                </div>
                  
                </div>
              </form><!-- End Multi Columns Form -->

            </div>
          </div>

        </div>
      </div>
    </section>

  </main><!-- End #main -->
  
   <script src="assets/js/main.js"></script>
  
  <script>
    $(function(){
      $('#submit_btn').on('click', function(){
        var err = '';
        if ($('#name').val() === '') {
            alert('お名前を入れてください');
            err = 1;
        }
        if ($('#email').val() === '') {
            alert('メールアドレスを入れてください');
            err = 1;
        } else if (!$('#email').val().match(/.+@.+\..+/g)){
            alert('正しいメールアドレスを入れてください');
            err = 1;
        }
        if ($('#password').val() === '') {
          alert('パスワードを入れてください');
          err = 1;
        }
        if (err === 1) return false; 
        $('#signUp_form').submit();
        });
      });
  </script>

<?php
@include('common.footer');
?>