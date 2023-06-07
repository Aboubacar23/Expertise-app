<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20230607073726 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE TABLE remontage_finition (id INT AUTO_INCREMENT NOT NULL, controle_carcasse VARCHAR(255) DEFAULT NULL, controle_cablage1 VARCHAR(255) DEFAULT NULL, controle_cablage2 VARCHAR(255) DEFAULT NULL, controle_cablage3 VARCHAR(255) DEFAULT NULL, controle_cablage4 VARCHAR(255) DEFAULT NULL, controle_sonde1 VARCHAR(255) DEFAULT NULL, controle_sonde2 VARCHAR(255) DEFAULT NULL, controle_sonde3 VARCHAR(255) DEFAULT NULL, controle_arbre1 VARCHAR(255) DEFAULT NULL, controle_arbre2 VARCHAR(255) DEFAULT NULL, controle_general1 VARCHAR(255) DEFAULT NULL, controle_general2 VARCHAR(255) DEFAULT NULL, controle_general3 VARCHAR(255) DEFAULT NULL, controle_general4 VARCHAR(255) DEFAULT NULL, controle_general5 VARCHAR(255) DEFAULT NULL, controle_general6 VARCHAR(255) DEFAULT NULL, controle_general7 VARCHAR(255) DEFAULT NULL, controle_general8 VARCHAR(255) DEFAULT NULL, controle_general9 VARCHAR(255) DEFAULT NULL, controle_general10 VARCHAR(255) DEFAULT NULL, controle_general11 VARCHAR(255) DEFAULT NULL, controle_carcasse2 VARCHAR(255) DEFAULT NULL, controle_cablage2_1 VARCHAR(255) DEFAULT NULL, controle_sonde2_1 VARCHAR(255) DEFAULT NULL, controle_arbre2_1 VARCHAR(255) DEFAULT NULL, controle_arbre2_2 VARCHAR(255) DEFAULT NULL, controle_arbre2_3 VARCHAR(255) DEFAULT NULL, controle_general2_1 VARCHAR(255) DEFAULT NULL, controle_general2_2 VARCHAR(255) DEFAULT NULL, controle_general2_3 VARCHAR(255) DEFAULT NULL, controle_general2_4 VARCHAR(255) DEFAULT NULL, controle_general2_5 VARCHAR(255) DEFAULT NULL, controle_general2_6 VARCHAR(255) DEFAULT NULL, controle_general2_7 VARCHAR(255) DEFAULT NULL, controle_general2_8 VARCHAR(255) DEFAULT NULL, controle_plaque1 VARCHAR(255) DEFAULT NULL, controle_plaques2 VARCHAR(255) DEFAULT NULL, controle_plaques3 VARCHAR(255) DEFAULT NULL, controle_plaque4 VARCHAR(255) DEFAULT NULL, controle_plaque5 VARCHAR(255) DEFAULT NULL, etat TINYINT(1) DEFAULT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('ALTER TABLE parametre ADD remontage_finition_id INT DEFAULT NULL');
        $this->addSql('ALTER TABLE parametre ADD CONSTRAINT FK_ACC790411231FB9D FOREIGN KEY (remontage_finition_id) REFERENCES remontage_finition (id)');
        $this->addSql('CREATE UNIQUE INDEX UNIQ_ACC790411231FB9D ON parametre (remontage_finition_id)');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE parametre DROP FOREIGN KEY FK_ACC790411231FB9D');
        $this->addSql('DROP TABLE remontage_finition');
        $this->addSql('DROP INDEX UNIQ_ACC790411231FB9D ON parametre');
        $this->addSql('ALTER TABLE parametre DROP remontage_finition_id');
    }
}
