<?php
use Migrations\AbstractMigration;

class PopulateTableStates extends AbstractMigration
{
    public function up () {
        $sql = "INSERT INTO states VALUES ('1', 'Acre', 'AC');
        INSERT INTO states VALUES ('2', 'Alagoas', 'AL');
        INSERT INTO states VALUES ('3', 'Amazonas', 'AM');
        INSERT INTO states VALUES ('4', 'Amapá', 'AP');
        INSERT INTO states VALUES ('5', 'Bahia', 'BA');
        INSERT INTO states VALUES ('6', 'Ceará', 'CE');
        INSERT INTO states VALUES ('7', 'Distrito Federal', 'DF');
        INSERT INTO states VALUES ('8', 'Espirito Santo', 'ES');
        INSERT INTO states VALUES ('9', 'Goiás', 'GO');
        INSERT INTO states VALUES ('10', 'Maranhão', 'MA');
        INSERT INTO states VALUES ('11', 'Minas Gerais', 'MG');
        INSERT INTO states VALUES ('12', 'Mato Grosso do Sul', 'MS');
        INSERT INTO states VALUES ('13', 'Mato Grosso', 'MT');
        INSERT INTO states VALUES ('14', 'Pará', 'PA');
        INSERT INTO states VALUES ('15', 'Paraíba', 'PB');
        INSERT INTO states VALUES ('16', 'Pernambuco', 'PE');
        INSERT INTO states VALUES ('17', 'Piauí', 'PI');
        INSERT INTO states VALUES ('18', 'Paraná', 'PR');
        INSERT INTO states VALUES ('19', 'Rio de Janeiro', 'RJ');
        INSERT INTO states VALUES ('20', 'Rio Grande do Norte', 'RN');
        INSERT INTO states VALUES ('21', 'Rondônia', 'RO');
        INSERT INTO states VALUES ('22', 'Roraima', 'RR');
        INSERT INTO states VALUES ('23', 'Rio Grande do Sul', 'RS');
        INSERT INTO states VALUES ('24', 'Santa Catarina', 'SC');
        INSERT INTO states VALUES ('25', 'Sergipe', 'SE');
        INSERT INTO states VALUES ('26', 'São Paulo', 'SP');
        INSERT INTO states VALUES ('27', 'Tocantins', 'TO');";
        $this->execute($sql);
    }
}
