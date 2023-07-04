<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20230704111458 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE TABLE coussinet (id INT AUTO_INCREMENT NOT NULL, ref_palier_ca VARCHAR(255) DEFAULT NULL, ref_palier_coa VARCHAR(255) DEFAULT NULL, num_code_ca INT DEFAULT NULL, photo_ca VARCHAR(255) DEFAULT NULL, num_code_coa INT DEFAULT NULL, photo_coa VARCHAR(255) DEFAULT NULL, etat TINYINT(1) DEFAULT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('ALTER TABLE parametre ADD coussinet_id INT DEFAULT NULL');
        $this->addSql('ALTER TABLE parametre ADD CONSTRAINT FK_ACC790411CFB891E FOREIGN KEY (coussinet_id) REFERENCES coussinet (id)');
        $this->addSql('CREATE UNIQUE INDEX UNIQ_ACC790411CFB891E ON parametre (coussinet_id)');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE parametre DROP FOREIGN KEY FK_ACC790411CFB891E');
        $this->addSql('DROP TABLE coussinet');
        $this->addSql('DROP INDEX UNIQ_ACC790411CFB891E ON parametre');
        $this->addSql('ALTER TABLE parametre DROP coussinet_id');
    }
}
