<?php

class DB
{
    /**
     * @var mysqli
     */
    private $conn;

    public function __construct()
    {
        $servername = DB_HOST;
        $username = DB_USER;
        $password = DB_PASSWD;
        $db = DB_NAME;
        $port = DB_PORT;

        // Create connection
        $this->conn = new mysqli($servername, $username, $password, $db, $port);
        // Check connection
        if ($this->conn->connect_error) {
            throw new Exception("Connection failed: " . $this->conn->connect_error);
        }
    }

    /**
     * @param string $filter Filters to apply
     * @return integer
     */
    public function count($filter = null)
    {
        $count = 0;
        $like = "%$filter%";
        $types = '';
        $baseQueryCount = "SELECT COUNT(p.id) as total
            FROM processos p ";
        if ($filter) {
            $baseQueryCount .= "WHERE p.id = ? OR p.nome LIKE ? ";
            $types .= "ss";
            $params[] = $filter;
            $params[] = $like;
        }
        $stmt1 = $this->conn->prepare($baseQueryCount);
        if ($types) {
            $stmt1->bind_param($types, ...$params);
        }
        $stmt1->execute();
        $stmt1->bind_result($count);
        $stmt1->fetch();
        while ($this->conn->more_results()) {
            $this->conn->next_result();
            $this->conn->use_result();
        }
        $stmt1->close();

        return $count;
    }

    /**
     * Returns the specified page of results
     * @param string $filter Filter string
     * 
     * @return array<Processo>
     */
    public function list($page = 1, $filter = null)
    {

        $start = ($page - 1) * RECORD_PER_PAGE;
        $limit = RECORD_PER_PAGE;
        $types = '';
        $params = [];
        $lista = [];
        $like = "%$filter%";
        $baseQuery = "SELECT p.id as p_id, p.nome as p_nome,
            p.status as p_status, p.data_criacao as p_data_criacao,
            p.data_modificacao as p_data_modificacao, p.id_volk as p_id_volk,
            pe.id as pe_id, pe.nome as pe_nome, u.id as u_id, u.nome as u_nome
            FROM processos p LEFT JOIN pessoas pe ON (p.pessoa_id = pe.id)
            LEFT JOIN unidades u ON (u.id = p.unidade_id) ";
        if ($filter) {
            $baseQuery .= "WHERE p.id = ? OR p.nome LIKE ? ";
            $types .= "ss";
            $params[] = $filter;
            $params[] = $like;
        }
        $types .= "ii";
        $params[] = $start;
        $params[] = $limit;
        $baseQuery = $baseQuery . " LIMIT ?, ?";
        $stmt = $this->conn->prepare($baseQuery);
        $stmt->bind_param($types, ...$params);
        $stmt->execute();
        $result = $stmt->get_result();
        while ($row = $result->fetch_assoc()) {
            $pes = new Pessoa();
            $pes->setId($row['pe_id']);
            $pes->setNome($row['pe_nome']);
            $un = new Unidade();
            $un->setId($row['u_id']);
            $un->setNome($row['u_nome']);
            $pro = new Processo();
            $pro->setId($row['p_id']);
            $pro->setName($row['p_nome']);
            $pro->setPessoa($pes);
            $pro->setUnidade($un);
            $pro->setCreatedDate(new DateTime($row['p_data_criacao']));
            $pro->setModifiedDate(new DateTime($row['p_data_modificacao']));
            $pro->setStatus($row['p_status']);
            $pro->setIdVolk($row['p_id_volk']);
            $lista[] = $pro;
        }

        while ($this->conn->more_results()) {
            $this->conn->next_result();
            $this->conn->use_result();
        }
        return $lista;
    }

    /**
     * Saves a processo
     * @param Processo $processo The processo entity
     * @return void
     */
    public function save($processo)
    {
        $queryNew = "INSERT INTO evolke.processos
        (nome, pessoa_id, unidade_id, status, data_criacao, data_modificacao, id_volk)
        VALUES(?, ?, ?, ?, ?, ?, ?)";
        $queryUpdate = "UPDATE processos
        SET nome=?, pessoa_id=?, unidade_id=?, status=?, data_modificacao=?, id_volk=?
        WHERE id=?";
        $types = '';
        $params = [];
        if ($processo->getId() == 0) {
            $stmt = $this->conn->prepare($queryNew);
            $types = 'siisssi';
            $params[] = $processo->getName();
            $params[] = $processo->getPessoa()->getId();
            $params[] = $processo->getUnidade()->getId();
            $params[] = $processo->getStatus();
            $params[] = $processo->getCreatedDate()->format('Y-m-d H:i:s');
            $params[] = $processo->getModifiedDate()->format('Y-m-d H:i:s');
            $params[] = $processo->getIdVolk();
        } else {
            $stmt = $this->conn->prepare($queryUpdate);
            $types = 'siissii';
            $params[] = $processo->getName();
            $params[] = $processo->getPessoa()->getId();
            $params[] = $processo->getUnidade()->getId();
            $params[] = $processo->getStatus();
            $params[] = $processo->getModifiedDate()->format('Y-m-d H:i:s');
            $params[] = $processo->getIdVolk();
            $params[] = $processo->getId();
        }
        $stmt->bind_param($types, ...$params);
        $stmt->execute();
        while ($this->conn->more_results()) {
            $this->conn->next_result();
            $this->conn->use_result();
        }
    }

    /**
     * Deletes a processo
     * @param int $id The id of the process
     * @return void
     */
    public function delete($id)
    {
        $stmt = $this->conn->prepare('Delete from processos where id = ?');
        $stmt->bind_param('i', $id);
        $stmt->execute();
        while ($this->conn->more_results()) {
            $this->conn->next_result();
            $this->conn->use_result();
        }
    }

    /**
     * Finds a processo
     * @param int $id The id of the process
     * @return Processo|null 
     */
    public function find($id)
    {
        $stmt = $this->conn->prepare('SELECT p.id as p_id, p.nome as p_nome,
        p.status as p_status, p.data_criacao as p_data_criacao,
        p.data_modificacao as p_data_modificacao, p.id_volk as p_id_volk,
        pe.id as pe_id, pe.nome as pe_nome, u.id as u_id, u.nome as u_nome
        FROM processos p LEFT JOIN pessoas pe ON (p.pessoa_id = pe.id)
        LEFT JOIN unidades u ON (u.id = p.unidade_id)  where p.id = ?');
        $stmt->bind_param('i', $id);
        $stmt->execute();
        $result = $stmt->get_result();
        while ($row = $result->fetch_assoc()) {
            $pes = new Pessoa();
            $pes->setId($row['pe_id']);
            $pes->setNome($row['pe_nome']);
            $un = new Unidade();
            $un->setId($row['u_id']);
            $un->setNome($row['u_nome']);
            $pro = new Processo();
            $pro->setId($row['p_id']);
            $pro->setName($row['p_nome']);
            $pro->setPessoa($pes);
            $pro->setUnidade($un);
            $pro->setCreatedDate(new DateTime($row['p_data_criacao']));
            $pro->setModifiedDate(new DateTime($row['p_data_modificacao']));
            $pro->setStatus($row['p_status']);
            $pro->setIdVolk($row['p_id_volk']);
            return $pro;
        }
        while ($this->conn->more_results()) {
            $this->conn->next_result();
            $this->conn->use_result();
        }
        return null;
    }

    /**
     * List all the Pessoa records
     * @return array<Pessoa>
     */
    public function listPessoas()
    {
        $list = [];
        if ($result = $this->conn->query('SELECT * FROM pessoas')) {
            while ($row = $result->fetch_object()) {
                $obj = new Pessoa();
                $obj->setId($row->id);
                $obj->setNome($row->nome);
                $list[] = $obj;
            }
            while ($this->conn->more_results()) {
                $this->conn->next_result();
                $this->conn->use_result();
            }
        }
        return $list;
    }

    /**
     * List all the Unidade records
     * @return array<Unidade>
     */
    public function listUnidades()
    {
        $list = [];
        if ($result = $this->conn->query('SELECT * FROM unidades')) {
            while ($row = $result->fetch_object()) {
                $obj = new Unidade();
                $obj->setId($row->id);
                $obj->setNome($row->nome);
                $list[] = $obj;
            }
            while ($this->conn->more_results()) {
                $this->conn->next_result();
                $this->conn->use_result();
            }
        }
        return $list;
    }
}