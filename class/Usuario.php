<?php 
class Usuario {
	private $idusuario;
	private $deslogin;
	private $dessenha;
	private $dtcadastro;

   // Método construtor
   public function __construct( $login = "", $password = "" ) {
		$this->setDeslogin( $login );
		$this->setDessenha( $password );
	}

	public function __toString() {
      return json_encode( array( "idusuario" => $this->getIdusuario(),
                                 "deslogin" => $this->getDeslogin(),
                                 "dessenha" => $this->getDessenha(),
                                 "dtcadastro" => $this->getDtcadastro()->format( "d/m/Y H:i:s" ) ) );
	}

   // getters
	public function getIdusuario() {
		return $this->idusuario;
	}

	public function getDeslogin() {
		return $this->deslogin;
	}

	public function getDessenha() {
		return $this->dessenha;
	}

	public function getDtcadastro() {
		return $this->dtcadastro;
	}

   // setters
   public function setIdusuario( $value ) {
		$this->idusuario = $value;
	}

	public function setDeslogin( $value ) {
		$this->deslogin = $value;
	}

	public function setDessenha( $value ) {
		$this->dessenha = $value;
	}

	public function setDtcadastro( $value ) {
		$this->dtcadastro = $value;
	}

   // ======================================================
   
	public function setData( $data ) {
		$this->setIdusuario( $data[ 'idusuario' ] );
		$this->setDeslogin( $data[ 'deslogin' ] );
		$this->setDessenha( $data[ 'dessenha' ] );
		$this->setDtcadastro( new DateTime( $data[ 'dtcadastro' ] ) );
	}

   // Carrega um registro pela ID
	public function loadById( $id ) {
		$sql    = new Sql();
		$result = $sql->select( "SELECT * FROM tb_usuarios WHERE idusuario = :ID;", array( ":ID" => $id ) );

		if ( count( $result ) > 0 ) {
			$this->setData( $result[ 0 ] );
		}
	}

   // Carrega uma lista de registros.
   // Método criado como  estático por não possuir chamadas a atributos e métodos da classe ($this->),
   // assim pode ser chamado sem a necessidade de instanciar a classe.
	public static function getList() {
		$sql = new Sql();

      // Como não existem parâmetros a serem passados, select() recebeu apenas a string SQL.
		return $sql->select( "SELECT * FROM tb_usuarios ORDER BY deslogin;" );
	}

   // Efetua busca pelo campo do login de usuário
	public static function search( $login ) {
		$sql = new Sql();

      return $sql->select( "SELECT * FROM tb_usuarios WHERE deslogin LIKE :SEARCH ORDER BY deslogin;",
                           array( ':SEARCH' => "%" . $login . "%" ) );
	}

   // Carrega o registro com autenticação de usuário e senha
	public function login( $login, $password ) {
		$sql    = new Sql();
      $result = $sql->select( "SELECT * FROM tb_usuarios WHERE deslogin = :LOGIN AND dessenha = :PASSWORD;",
                               array( ":LOGIN" => $login, ":PASSWORD" => $password ) );

		if ( count( $result ) > 0 ) {
			$this->setData( $result[ 0 ] );
		} else {
			throw new Exception( "Login e/ou senha inválidos." );
		}
	}

   // Insere um registro na tabela
	public function insert() {
      $sql = new Sql();

      // CALL é usado para executar procedures do MySQL. No SQL Server é EXECUTE
      $result = $sql->select( "CALL sp_usuarios_insert( :LOGIN, :PASSWORD )",
                               array( ':LOGIN' => $this->getDeslogin(), ':PASSWORD' => $this->getDessenha() ) );

		if ( count( $result ) > 0 ) {
			$this->setData( $result[ 0 ] );
		}
	}

   // Altera um registro específico na tabela
	public function update( $login, $password ) {
		$this->setDeslogin( $login );
		$this->setDessenha( $password );

		$sql = new Sql();

      $sql->query( "UPDATE tb_usuarios SET deslogin = :LOGIN, dessenha = :PASSWORD WHERE idusuario = :ID;",
                   array( ':LOGIN' => $this->getDeslogin(), ':PASSWORD' => $this->getDessenha(), ':ID' => $this->getIdusuario() ) );
	}

   // Exclui um registro da tabela
	public function delete() {
		$sql = new Sql();

		$sql->query( "DELETE FROM tb_usuarios WHERE idusuario = :ID;", array( ':ID' => $this->getIdusuario() ) );

		$this->setIdusuario( 0 );
		$this->setDeslogin( "" );
		$this->setDessenha( "" );
		$this->setDtcadastro( new DateTime() );
	}
} 	
?>