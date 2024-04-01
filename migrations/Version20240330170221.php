<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20240330170221 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE medical_file DROP FOREIGN KEY FK_DF6C9C38592AF3BA');
        $this->addSql('ALTER TABLE medical_file DROP FOREIGN KEY FK_DF6C9C38A76ED395');
        $this->addSql('ALTER TABLE medical_file DROP FOREIGN KEY FK_DF6C9C38DFF56A4A');
        $this->addSql('DROP TABLE medical_file');
        $this->addSql('ALTER TABLE medical ADD doc_object_id INT DEFAULT NULL');
        $this->addSql('ALTER TABLE medical ADD CONSTRAINT FK_77DB075ADFF56A4A FOREIGN KEY (doc_object_id) REFERENCES doc_object (id)');
        $this->addSql('CREATE UNIQUE INDEX UNIQ_77DB075ADFF56A4A ON medical (doc_object_id)');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE TABLE medical_file (id INT AUTO_INCREMENT NOT NULL, medical_id INT DEFAULT NULL, doc_object_id INT DEFAULT NULL, user_id INT DEFAULT NULL, created_at DATETIME DEFAULT NULL, INDEX IDX_DF6C9C38592AF3BA (medical_id), INDEX IDX_DF6C9C38A76ED395 (user_id), INDEX IDX_DF6C9C38DFF56A4A (doc_object_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB COMMENT = \'\' ');
        $this->addSql('ALTER TABLE medical_file ADD CONSTRAINT FK_DF6C9C38592AF3BA FOREIGN KEY (medical_id) REFERENCES medical (id) ON UPDATE NO ACTION ON DELETE NO ACTION');
        $this->addSql('ALTER TABLE medical_file ADD CONSTRAINT FK_DF6C9C38A76ED395 FOREIGN KEY (user_id) REFERENCES user (id) ON UPDATE NO ACTION ON DELETE NO ACTION');
        $this->addSql('ALTER TABLE medical_file ADD CONSTRAINT FK_DF6C9C38DFF56A4A FOREIGN KEY (doc_object_id) REFERENCES doc_object (id) ON UPDATE NO ACTION ON DELETE NO ACTION');
        $this->addSql('ALTER TABLE medical DROP FOREIGN KEY FK_77DB075ADFF56A4A');
        $this->addSql('DROP INDEX UNIQ_77DB075ADFF56A4A ON medical');
        $this->addSql('ALTER TABLE medical DROP doc_object_id');
    }
}
